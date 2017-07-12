import { Component, OnInit, Input, Output, EventEmitter } from '@angular/core'

import { Observable } from 'rxjs/Observable'
import 'rxjs/add/observable/of'

import { AbDataProcessing } from './data.prosessing.service'
import { GenericService } from './xhr.service'

declare const abc: any

@Component({
  selector: 'ab-ng-accommodation',
  template: require('./accommodation.component.html'),
  styles: [`
    .woocommerce-Price-amount.amount {
      margin-top: -25px;
    }
  `]
})

export class AbNgAccommodationComponent implements OnInit {
  private viewInfo: any
  private zones: object[] = []
  private dates: any
  private cart: any = {
    accommodation: {}
  }
  private endpoint = `/wp-admin/admin-ajax.php`
  private extraFess

  @Input() course
  @Input() wooData
  @Output() setWooData = new EventEmitter()
  @Output() setCourseData = new EventEmitter()

  constructor (private dataProc: AbDataProcessing, private genericService: GenericService) {}

  ngOnInit () {
    this.setExtraFees()
    this.viewInfo = abc.viewInfo.accommodation
    this.extraFess = this.course
    this.viewInfo.extras = abc.viewInfo.extras.options
    this.viewInfo.visas = abc.viewInfo.visa.options
  }

  captureData (parent, prop, value) {
    if (!this.cart.hasOwnProperty(parent)) this.cart[parent] = {}
    this.cart[parent][prop] = value
    this.setExtraFees()

    if (prop === 'back_meal_plan' && value && this.cart.accommodation.back_accomdation) {
      this.getAccommodationData(value)
    }
    if (prop === 'back_product_acc_zone' && value && this.cart.accommodation.back_accomdation) {
      this.updateCart()
    }
    if (prop === 'back_transport_type' && value && this.cart.accommodation.back_accomdation) {
      this.setGenData(value, 'add_transportation', 'acctransportproc_id')
    }
    if (prop === 'back_visa_require' && value && this.cart.accommodation.back_accomdation) {
      this.setGenData(value, 'add_visa', 'accvisaproc_id')
    }
    if (prop === 'under_18' && value && this.cart.accommodation.back_accomdation) {
      this.setAge(value)
    }
    if (prop === 'back_bathroom' && value && this.cart.accommodation.back_accomdation) {
      this.setBathroom(value)
    }

    // 21133

    sessionStorage.setItem('accommodation', JSON.stringify(this.cart.accommodation))
    this.setCourseData.emit(this.cart)
  }

  setExtraFees() {
    // this.cart.accommodation.extracharges = (this.wooData && this.wooData.fees && this.wooData.fees.courseExtras) ? this.wooData.fees.courseExtras : ''
    this.cart.accommodation.extracharges = ''
  }

  setBathroom (value) {
    Observable.of(value)
      .switchMap(data => {
        if (value === 'no' || value === '') {
          return this.genericService.saveData(
            `${this.endpoint}?action=remove_bath`,
            {
              'action': 'remove_bath'
            },
            true
          )
        }

        if (value === 'yes') {
          let bathroom_id = 21133
          return this.genericService.saveData(
            `${this.endpoint}?action=get_accommodation_variation_id`, 
            {
              'action': 'get_accommodation_variation_id',
              'acczone': this.cart.accommodation.back_product_acc_zone, 
              'product_id': bathroom_id
            },
            true
          )
          .switchMap(data => {
            return this.genericService.getJsonData(
              `${this.endpoint}?add-to-cart=${bathroom_id}&variation_id=${data.variation_id}
              &quantity=${this.dataProc.getWeeks(this.dates.start, this.dates.end)}
              &attribute_pa_zone=${this.cart.accommodation.back_product_acc_zone}`, 
            )
          })
        } 
      })
      .switchMap(data => {
        return this.getCartData()
      })
      .subscribe(res => {
        console.log('res', res)
      })
  }

  setAge (value) {
    Observable.of(value)
      .switchMap(data => {
        if (value === 'no' || value === '') {
          return this.genericService.saveData(
            `${this.endpoint}?action=remove_under_18`,
            {
              'action': 'remove_under_18'
            },
            true
          )
        }

        if (value === 'yes') {
          return this.genericService.getJsonData(
            `${this.endpoint}?add-to-cart=21195&quantity=${this.dataProc.getWeeks(this.dates.start, this.dates.end)}`, 
          )
        } 
      })
      .switchMap(data => {
        return this.getCartData()
      })
      .subscribe(res => {
        console.log('res', res)
      })
  }

  getAccommodationData (value) {
    this.postData(
      `${this.endpoint}?action=get_accommodation_data`, 
      { 
        'action': 'get_accommodation_data', 
        'product_id': value,
        'course': this.course
      }, 
      true
    )
  }

  postData (endpoint: string, data: any, json = false) {
    this.genericService.saveData(
      `${endpoint}`, 
      data,
      json
    )
    .subscribe(res => {
      if (data.action === 'get_accommodation_data') {
        this.updateViewData(res)
      }
      if (data.action === 'get_cart_data') {
        // this.updateWooCart(res)
      }
    })
  }

  updateViewData (res) {
    abc.viewInfo.accommodation.zones = res.zones
    abc.viewInfo.accommodation.dates = res.dates
    this.zones = res.zones
    this.dates = res.dates
  }

  isVisible (parentId, childId) {
    return (this.dataProc.accomOptions(parentId, childId) >= 0) ? true : false
  }

  setGenData (value, action, prop, actionKey = 'action=') {
    this.genericService.saveData(
      `${this.endpoint}?${actionKey}${action}`, 
      {
        'action': `${action}`,
        [`${prop}`]: value,
        'course': this.course
      },
      true
    )
    .switchMap(data => {
      return this.getCartData()
      .map(res => {
        let response = {
          accommodation_variation_id: data.accommodation_variation_id,
          cart: res
        }
        return response
      })
    })
    .subscribe(res => {
      console.log('res', res)
    })
  }

  updateCart () {
    this.genericService.saveData(
      `${this.endpoint}?action=get_accommodation_variation_id`, 
      {
        'action': 'get_accommodation_variation_id',
        'acczone': this.cart.accommodation.back_product_acc_zone, 
        'product_id': this.cart.accommodation.back_meal_plan
      },
      true
    )
    .switchMap(response => {
      let data = response
      this.cart.accommodation.variation_id = data.variation_id
      this.cart.accommodation.acc_week = this.dataProc.getWeeks(this.dates.start, this.dates.end)
      return this.genericService.getJsonData(
        `${this.endpoint}?add-to-cart=${this.cart.accommodation.back_meal_plan}&variation_id=${data.variation_id}&quantity=${this.dataProc.getWeeks(this.dates.start, this.dates.end)}&attribute_pa_zone=${this.cart.accommodation.back_product_acc_zone}`, 
      )
      .map(res => {
        let response = {
          accommodation_variation_id: data.variation_id
        }
        return response
      })
    })
    .switchMap(data => {
      return this.getCartData()
      .map(res => {
        let response = {
          accommodation_variation_id: data.accommodation_variation_id,
          cart: res
        }
        return response
      })
    })
    .subscribe(res => {
      console.log('res', res)
      this.setWooData.emit(res.cart)
      // this.updateWooCart(res)
    })
  }

  getCartData () {
    return this.genericService.saveData(
      `${this.endpoint}?action=get_accommodation_cart_data`, 
        {
          'action': 'get_accommodation_cart_data',
          'accommodation': this.cart.accommodation
        },
        true
    )
  }
}