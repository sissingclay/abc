import { Component, OnInit, Input, OnChanges } from '@angular/core'

import { AbDataProcessing } from './data.prosessing.service'

declare const abc: any

@Component({
  selector: 'ab-ng-cart-view',
  template: require('./cart.view.component.html'),
  styles: [`
    .woocommerce-Price-amount.amount {
      margin-top: -25px;
    }
    .priceright {
      margin-top: -25px;
    }
  `]
})

export class AbNgCartViewComponent implements OnInit, OnChanges {
  private abc = abc
  private cart: any = {}

  @Input() courseData: any = {}
  @Input() wooData: any = {}

  constructor (private abDataProcessing: AbDataProcessing) {}

  ngOnInit () {
    console.log('courseData', this.courseData)
  }

  ngOnChanges () {
    console.log('this.courseData', this.courseData)
    if (this.courseData && this.courseData.hasOwnProperty('course')) this.cart.course = this.courseData.course
    if (this.courseData && this.courseData.hasOwnProperty('accommodation')) this.cart.accommodation = this.courseData.accommodation
  }

  getName (value, options) {
    let name: string = ''
    abc.viewInfo.course[options].filter(option => {
      if (option.the_id && option.the_id === value) name = option.product_radio_title
      if (option.slug && option.slug === value) name = option.name
    })
    return name
  }

  getCourseName (value) {
    switch (value) {
      case '1':
        return 'Callan Method'
      case '2':
        return 'General English'
      case '5':
        return 'Exam Courses'
      case '4':
        return 'One-to-one'
    }
  }

  getSectionTotal (data) {
    return Object.keys(data).map(key => {
      return parseFloat(data[key].line_total).toFixed(2)
    })
  }

  getTotal () {
    let total = (this.wooData && this.wooData.cart) ? this.wooData.total : 0
    this.wooData.fees.courseExtras.map(val => {
      total += parseFloat(val.amount)
    })
    return total
  }
}
