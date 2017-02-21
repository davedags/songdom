import { Component, OnInit, AfterViewInit, OnDestroy } from '@angular/core';
import { SpeechRecognitionService } from '../speech-recognition.service'
import { Song } from '../song';
import { SongService } from '../song.service';

@Component({
  selector: 'app-search',
  providers: [
    SongService,
    SpeechRecognitionService
  ],
  templateUrl: './search.component.html',
  styleUrls: ['./search.component.css']
})
export class SearchComponent implements OnInit, AfterViewInit, OnDestroy {

  songResult: Song;
  searchTerm: string;
  speechData: string;

  constructor(private songService: SongService, private speechRecognitionService: SpeechRecognitionService) {
    this.speechData = "";
  }

  ngOnInit() {
    this.reset();
  }

  ngAfterViewInit() {
    this.activateSpeechSearch();
  }

  ngOnDestroy() {
    this.disableSpeechSearch();
  }
  getSong(): void {
    this.songService.getSong(this.searchTerm).then(song => this.songResult = song);
    this.disableSpeechSearch();
  }

  reset(): void {
    this.searchTerm = '';
    this.songResult = new Song;
    this.disableSpeechSearch();
    this.activateSpeechSearch();
  }

  clearSearch(element): void {
    this.reset();
    element.focus();
  }

  activateSpeechSearch(): void {

    this.speechRecognitionService.record()
        .subscribe(
            //listener
            (value) => {
              this.searchTerm = value;
              this.getSong();
            },
            //errror
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

  disableSpeechSearch(): void {
    this.speechRecognitionService.DestroySpeechObject();
  }
}
