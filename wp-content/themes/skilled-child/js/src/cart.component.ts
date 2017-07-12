import { Component, OnInit, Output, EventEmitter } from '@angular/core'

import { AbDataProcessing } from './data.prosessing.service'
import { GenericService } from './xhr.service'

declare const abc: any

@Component({
  selector: 'ab-ng-cart',
  template: require('./cart.component.html')
})

export class AbNgCartComponent implements OnInit {
  private cart: any = {
    course: {
      back_coursestartdate: ''
    }
  }
  private viewInfo
  private endpoint = `/wp-admin/admin-ajax.php`
  private weeks: object[] = []
  private levels: object[] = []
  private woo_cart: any

  @Output() setCourseData = new EventEmitter()
  @Output() setWooData = new EventEmitter()

  constructor (private dataProc: AbDataProcessing, private genericService: GenericService) {}

  ngOnInit () {
    this.viewInfo = abc.viewInfo
    let wooCartData = Object.keys(abc.cart.wooCart)
    if (abc && abc.cart && Object.keys(wooCartData).length) {
      let storedData = JSON.parse(sessionStorage.getItem('cart'))
      this.genericService.saveData(
        `${this.endpoint}?action=get_course_data`, 
        { 
          'action': 'get_course_data', 
          'product_id': abc.cart.wooCart[`${wooCartData}`].product_id,
          'keepWooCart': true
        }, 
        true
      )
      .switchMap(courseData => {
        return this.genericService.saveData(
            `${this.endpoint}?action=get_cart_data`, 
            { 
              'action': 'get_cart_data',
              'product_id': storedData.course.back_productid, 
              'variation_id': storedData.course.variation_id, 
              'current_course_product_id': storedData.course.back_productid,
              'quantity': 1,
              'back_ex_student': (storedData.course.back_ex_student) ? storedData.course.back_ex_student : 'no',
              'sessionData': storedData.course
            }, 
            true
          )
          .map(res => {
            let response = {
              viewData :courseData,
              wooCart: {
                course_cart: res,
                course_variation_id: abc.cart.wooCart[`${wooCartData}`].variation_id
              }
            }
            return response
          })
      })
      .subscribe(res => {
        this.updateViewData(res.viewData)
        this.updateWooCart(res.wooCart)
        this.cart = JSON.parse(sessionStorage.getItem('cart'))
        console.log('this.cart', this.cart)
        this.emitCourseData(this.cart)
      })
    }
  }

  postData (endpoint: string, data: any, json = false) {
    this.genericService.saveData(
      `${endpoint}`, 
      data,
      json
    )
    .subscribe(res => {
      if (data.action === 'get_course_data') {
        this.updateViewData(res)
      }
      if (data.action === 'get_cart_data') {
        this.updateWooCart(res)
      }
    })
  }

  updateWooCart (res) {
    if (!res.course_cart) res.course_cart = res
    this.woo_cart = res
    this.setWooData.emit(this.woo_cart.course_cart)
  }

  updateViewData (res) {
    abc.viewInfo.course.weeks = res.weeks
    abc.viewInfo.course.levels = res.levels
    this.weeks = res.weeks
    this.levels = res.levels
  }

  getCourseData (value) {
    this.postData(
      `${this.endpoint}?action=get_course_data`, 
      { 
        'action': 'get_course_data', 
        'product_id': value
      }, 
      true
    )
  }

  isVisible (parentId, childId) {
    return (this.dataProc.courseRadio(parentId, childId) >= 0) ? true : false
  }

  captureData (parent, prop, value) {
    if (!this.cart.hasOwnProperty(parent)) this.cart[parent] = {}
    this.cart[parent][prop] = value
    if (prop === 'back_productid' && value && this.cart.course.back_productid) {
      this.getCourseData(value)
    }
    if (prop === 'back_courseweek' && value && this.cart.course.back_productid) {
      this.updateCart()
    }
    if (prop === 'back_ex_student' && value && this.cart.course.back_productid) {
      this.updateCart()
    }

    sessionStorage.setItem('cart', JSON.stringify(this.cart))
    this.emitCourseData(this.cart)
  }

  emitCourseData (cart) {
    this.setCourseData.emit(cart)
  }

  updateCart () {
    this.genericService.saveData(
      `${this.endpoint}?action=get_variation_id`, 
      {
        'action': 'get_variation_id',
        'courseweek': this.cart.course.back_courseweek, 
        'product_id': this.cart.course.back_productid
      },
      true
    )
    .switchMap(response => {
      let data = response
      this.cart.course.variation_id = data.variation_id
      return this.genericService.saveData(
        `${this.endpoint}?action=set_cart_data`, 
        { 
          'product_id': this.cart.course.back_productid, 
          'variation_id': data.variation_id, 
          'quantity': 1,
          'current_course_product_id': (this.woo_cart && this.woo_cart.course_product_id) ? parseInt(this.woo_cart.course_product_id) : '',
          'back_ex_student': (this.cart.course.back_ex_student) ? this.cart.course.back_ex_student : 'no',
          'sessionData': this.cart.course
        }, 
        true
      )
      .map(res => {
        let response = {
          course_cart: res,
          course_variation_id: data.variation_id
        }
        return response
      })
    })
    .subscribe(res => {
      this.updateWooCart(res)
    })
  }
}