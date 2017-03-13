import { Component, AfterViewInit, OnDestroy } from '@angular/core';
import { SpeechRecognitionService } from './speech-recognition.service'
import { Song, SongService } from './song.service';

@Component({
  selector: 'app-search',
  providers: [
    SongService,
    SpeechRecognitionService
  ],
  templateUrl: './search.component.html',
  styleUrls: ['./search.component.css']
})
export class SearchComponent implements AfterViewInit, OnDestroy {

  songResult: Song;
  searchTerm: string;
  haveSearched: boolean;
  speechListening: boolean;
  speechSupported: boolean;
  speechData: string;

  constructor(private songService: SongService, private speechRecognitionService: SpeechRecognitionService) {
    this.speechData = '';
    this.haveSearched = false;
    this.searchTerm = '';
    this.songResult = new Song('', '');
    if ('webkitSpeechRecognition' in window) {
      this.speechSupported = true;
      this.speechListening = true;
    } else {
      this.speechSupported = false;
      this.speechListening = false;
    }
  }

  ngAfterViewInit() {
    this.activateSpeechSearch();
  }

  ngOnDestroy() {
    this.disableSpeechSearch();
  }
  getSong(): void {
    this.songService.getSong(this.searchTerm).then(song => {
      this.songResult = song;
      this.haveSearched = true;
    });
    this.disableSpeechSearch();
  }

  reset(): void {
    this.searchTerm = '';
    this.haveSearched = false;
    this.songResult.url = '';
    this.songResult.lyrics = '';
    this.activateSpeechSearch();
  }

  clearSearch(element): void {
    this.reset();
    element.focus();
  }

  activateSpeechSearch(): void {
    if (this.speechSupported == true) {

      this.speechRecognitionService.record()
          .subscribe(
              //listener
              (value) => {
                if (value == 'voice') {
                  this.speechListening = !this.speechListening;
                } else {
                  if (this.speechListening) {
                    if (this.searchTerm == '') {
                      this.searchTerm = value;
                      this.getSong();
                    } else if (value == 'clear') {
                      this.reset();
                    }
                  }
                }
                if (value == 'disable voice') {
                  this.disableSpeechSearch();
                  this.speechSupported = false;
                }
              },
              //error
              (err) => {
                if (err.error == "no-speech") {
                  this.activateSpeechSearch();
                }
              },
              //completion
              () => {
                this.activateSpeechSearch();
              });
    }
  }

  disableSpeechSearch(): void {
    if (this.speechSupported == true) {
      this.speechRecognitionService.DestroySpeechObject();
    }
  }
}
