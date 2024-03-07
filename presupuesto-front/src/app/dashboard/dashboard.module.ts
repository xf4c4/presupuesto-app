import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { DashboardRoutingModule } from './dashboard-routing.module';
import { MainpageComponent } from './pages/mainpage/mainpage.component';
import { RouterModule } from '@angular/router';
import { DashboardComponent } from './components/dashboard/dashboard.component';
import { TransactionsComponent } from './components/transactions/transactions.component';
import { HistoryComponent } from './components/history/history.component';


@NgModule({
  declarations: [
    MainpageComponent,
    DashboardComponent,
    TransactionsComponent,
    HistoryComponent
  ],
  imports: [
    CommonModule,
    DashboardRoutingModule,
    RouterModule
  ]
})
export class DashboardModule { }
