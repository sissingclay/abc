import { NgModule } from '@angular/core'
import { ReactiveFormsModule, FormsModule } from '@angular/forms'
import { BrowserModule, Title } from '@angular/platform-browser'
import { HttpModule } from '@angular/http'

import { AppComponent } from './app.component'
import { AbNgCartComponent } from './cart.component'
import { AbNgAccommodationComponent } from './accommodation.component'
import { AbNgCartViewComponent } from './cart.view.component'

import { AbDataProcessing } from './data.prosessing.service'
import { GenericService } from './xhr.service'

@NgModule({
    imports: [
        BrowserModule,
        FormsModule,
        ReactiveFormsModule,
        HttpModule
    ],
    declarations: [
        AppComponent,
        AbNgCartComponent,
        AbNgCartViewComponent,
        AbNgAccommodationComponent
    ],
    providers: [
      Title,
      AbDataProcessing,
      GenericService
    ],
    bootstrap: [ AppComponent ]
})

export class AppModule {}
