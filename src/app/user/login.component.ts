import { Component, AfterViewInit, EventEmitter } from '@angular/core';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.css']
})
export class LoginComponent implements AfterViewInit {
    user: any = {};
    public focusTriggerEventEmitter = new EventEmitter<boolean>();

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
    }
}
