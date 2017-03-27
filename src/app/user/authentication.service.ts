/**
 * Created by daved_000 on 3/26/2017.
 */
import { Injectable } from '@angular/core';
import { Http} from "@angular/http";
import { environment } from '../../environments/environment';
import 'rxjs/add/operator/toPromise';

@Injectable()
export class AuthenticationService {

    private apiUrl = environment.baseAPIUrl + "authentication";

    constructor(private http:Http) {
    }

    
}
    
    