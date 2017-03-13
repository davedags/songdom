/**
 * Created by daved_000 on 3/13/2017.
 */
import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { LoginComponent } from './login.component';

const userRoutes: Routes = [
    { path: 'login', component: LoginComponent }
];

@NgModule({
    imports: [
        RouterModule.forChild(userRoutes)
    ],
    exports: [
        RouterModule
    ]
})

export class UserRoutingModule {}