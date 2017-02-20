import { Injectable } from '@angular/core';
import { Song } from './song';
import { URLSearchParams, Http} from "@angular/http";
import { environment } from '../environments/environment';
import 'rxjs/add/operator/toPromise';

@Injectable()
export class SongService {

  //private apiUrl = 'api/search';
  private apiUrl = environment.searchAPIUrl;

  constructor(private http: Http) {}

  getSong(searchTerm: string): Promise<Song> {
    let params: URLSearchParams = new URLSearchParams();
    params.set('q', searchTerm);

    return this.http.get(this.apiUrl, { search: params })
        .toPromise()
        .then(this.handleResponse)
        .catch(this.handleError);
  }

  private handleResponse(response: any): Promise<any> {
    return response.json();
  }
  private handleError(error: any): Promise<any> {
    console.error('An error occurred', error); // for demo purposes only
    return Promise.reject(error.message || error);
  }
}
