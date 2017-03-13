/**
 * Created by daved_000 on 3/13/2017.
 */
import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { SearchComponent } from './search.component';

const searchRoutes: Routes = [
    { path: '', component: SearchComponent }
];

@NgModule({
    imports: [
        RouterModule.forChild(searchRoutes)
    ],
    exports: [
        RouterModule
    ]
})

export class SearchRoutingModule {}