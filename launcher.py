from pathlib import Path
from main_utils import realTimeFacialLandmarks
from main_utils import smile_detection
from imutils.video import VideoStream
from imutils import face_utils
from keras.models import load_model
from keras.models import model_from_json
import time
import numpy as np
import pandas as pd
import cv2
import dlib
import json
import pyaudio
import wave
from audio import audio_processing
import threading
from threading import Thread
from predictionModal import modal

def setup_logical_control(file):
	print('f1')
	with open(file,'w') as fwrite:
		fwrite.write("================== Process Started ==================\n")
    

def start_realTimeVideo(file):
    t = 0
    landmarksArray = []
    smileScore = 0
    row = []
    featureArray = []
    column = ['Outer Eyebrow Height','Inner Eyebrow Height','Outer Lip Height','Inner Lip Height','Inner Eyebrow Distance','Lip Corner Distance','Eye Opening','Average Smile Score']

    fourcc = cv2.VideoWriter_fourcc(*'XVID')
    out = cv2.VideoWriter('data_save/output.avi', fourcc, 20.0, (640,480))

    emotion_labels = {0:'Neutral',1:'Neutral',2:'Neutral',3:'Smiling',4:'Neutral',5:'Surprise',6:'Neutral'}
    emotion_classifier = load_model('dependencies/fer2013.hdf5', compile=False)
    emotion_target_size = emotion_classifier.input_shape[1:3]

    face_haarCascade = cv2.CascadeClassifier('dependencies/haarcascade_frontalface_default.xml')
    eye_haarCascade = cv2.CascadeClassifier('dependencies/haarcascade_eye.xml')

    shapePredictorPath = 'dependencies/shape_predictor_68_face_landmarks.dat'
    faceDetector = dlib.get_frontal_face_detector()
    facialLandmarkPredictor = dlib.shape_predictor(shapePredictorPath)

    vs = VideoStream(usePiCamera = False).start()
	
    
    if file.exists():
        ## write our code for video taking
        while(file.exists()):

            frame = vs.read()
            gray = cv2.cvtColor(frame, cv2.COLOR_BGR2GRAY)
            cv2.equalizeHist(gray)
            faces = faceDetector(gray, 0)

            for (i, face) in enumerate(faces):

                facialLandmarks = facialLandmarkPredictor(gray, face)
                facialLandmarks = face_utils.shape_to_np(facialLandmarks)
                
                (x, y, w, h) = face_utils.rect_to_bb(face)
                cv2.rectangle(frame, (x, y), (x+w, y+h), (0, 255, 0), 2)
                cv2.putText(frame, '#{}'.format(i+1), (x, y-10), cv2.FONT_HERSHEY_SIMPLEX, 0.5, (0, 255, 0), 2)
                
                landmarksArray = realTimeFacialLandmarks.getDistance(facialLandmarks)
                realTimeFacialLandmarks.facialPointJson(t,landmarksArray)

                for (a, b) in facialLandmarks:
                    cv2.circle(frame, (a, b), 1, (0, 0, 255), -1)

                gray_face = smile_detection.processedFace(emotion_target_size,gray,x,y,w,h)
                emotion = smile_detection.predictEmotion(emotion_labels,emotion_classifier,gray_face)

                smileScore = smile_detection.getSmileScore(emotion_classifier,gray_face)
                smile_detection.smileJson(t,smileScore)
                
                t = t + 1
                
                temp = landmarksArray
                #print(temp)
				
                temp.append(smileScore)
                featureArray.append(temp)
                print(featureArray)

            out.write(frame)
            #cv2.imshow("Frame", frame)

        featureArray = np.array(featureArray)
        print("\nfeatures:\n",featureArray)
        for i in range(len(featureArray[0])):
            row.append(round(np.mean(featureArray[:,i])))
        print(row)

        df = pd.DataFrame(data = [row], columns = column)
        df.to_csv('data_save/realtime_video_cues.csv')

        out.release()
        #cv2.destroyAllWindows()
        vs.stop()
        
    else:
        print("No file")


def start_audio_capture(file):
    FORMAT = pyaudio.paInt16
    CHANNELS = 2
    RATE = 44100
    CHUNK = 1024
    RECORD_SECONDS = 10
    WAVE_OUTPUT_FILENAME = "./data_save/file.wav"
    
    if file.exists():
        audio = pyaudio.PyAudio()
        print("Audio recording started")
        # start Recording
        stream = audio.open(format=FORMAT, channels=CHANNELS, rate=RATE, input=True, frames_per_buffer=CHUNK)
        print("recording...")
        frames = []
        
        while(file.exists()):
            data = stream.read(CHUNK)
            frames.append(data)

        print("finished recording")
                
        # stop Recording
        stream.stop_stream()
        stream.close()
        audio.terminate()
        
        waveFile = wave.open(WAVE_OUTPUT_FILENAME, 'wb')
        waveFile.setnchannels(CHANNELS)
        waveFile.setsampwidth(audio.get_sample_size(FORMAT))
        waveFile.setframerate(RATE)
        waveFile.writeframes(b''.join(frames))
        waveFile.close()
    else:
        print("file not exist")


if __name__ == '__main__':
	
    file=Path("log.txt")
    setup_logical_control(file)

    realTimeVideo = Thread(target = start_realTimeVideo,kwargs={'file':file})
    audioCapture = Thread(target = start_audio_capture,kwargs={'file':file})

    realTimeVideo.start()
    audioCapture.start()

    # wait until both have completed their task
    realTimeVideo.join()
    audioCapture.join()

    #start audio processing
    #audio_processing.start_audio(file)

    #print("Prediction started")
    #modal.predict()
