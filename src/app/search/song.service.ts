import { Injectable } from '@angular/core';
import { URLSearchParams, Http} from "@angular/http";
import { environment } from '../../environments/environment';
import 'rxjs/add/operator/toPromise';

export class Song {
  constructor(public url: any, public lyrics: any) {}
}

@Injectable()
export class SongService {

  private apiUrl = environment.baseAPIUrl + "/search";
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
    return Promise.reject(error.message || error);
  }
}
