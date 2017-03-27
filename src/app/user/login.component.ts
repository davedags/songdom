import { Component, AfterViewInit, EventEmitter } from '@angular/core';
import { Router } from "@angular/router";
import { UserService } from "./user.service";
import { AuthenticationService } from "./authentication.service";

@Component({
  selector: 'app-login',
  providers: [
      AuthenticationService,
      UserService
  ],
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.css']
})
export class LoginComponent implements AfterViewInit {
    user: any = {};
    public focusTriggerEventEmitter = new EventEmitter<boolean>();

    constructor(
        private authenticationService: AuthenticationService,
        private userService: UserService,
        private router: Router) {}

    ngAfterViewInit() {
        this.focusInput();
    }
    focusInput() {
        this.focusTriggerEventEmitter.emit(true);
    }

    login() {
        
        console.log('user: ' + this.user.username + ' | password: ' + this.user.password);
       
    }
    
    register() {
        console.log('user: ' + this.user.username + ' | password: ' + this.user.password);
        this.userService.create(this.user)
            .subscribe(
                data => {
                    console.log('returned from the service create user');
                    console.log(data);
                    this.router.navigate(['/']);
                },
                error => {
                    //add error alert somewhere
                });
    }
}
