import { Component, OnInit } from '@angular/core';
import { Song } from '../song';
import { SongService } from '../song.service';

@Component({
  selector: 'app-search',
  providers: [SongService],
  templateUrl: './search.component.html',
  styleUrls: ['./search.component.css']
})
export class SearchComponent implements OnInit {

  songResult: Song;
  searchTerm: string;

  constructor(private songService: SongService) {}

  ngOnInit() {
    this.reset();
  }
  
  getSong(): void {
    this.songService.getSong(this.searchTerm).then(song => this.songResult = song);
  }

  reset(): void {
    this.searchTerm = '';
    this.songResult = new Song;
  }

  clearSearch(element): void {
    this.reset();
    element.focus();
  }
}
