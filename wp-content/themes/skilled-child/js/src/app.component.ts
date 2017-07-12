import { Component, OnInit } from '@angular/core'

@Component({
  selector: 'cart-app',
  template: require('./app.component.html'),
  styles: [`
    .smallerMargin {
      margin-top: 20px;
    }
    .img-thumbnail {
      width: 72px;
      height: 72px;
      clip-path: circle(30px at center);
    }

    li.media {
        border-bottom:1px dotted #f0f0f0;
    }
    .no-slash:before {
      display: none;
    }
`]
})

export class AppComponent implements OnInit {
  private courseData = {}
  private wooData = {}
  private course = {}

  ngOnInit () {
    console.log('app')
  }

  setCourseData (courseData) {
    console.log('courseData', courseData)
    this.courseData = courseData
    if (courseData && courseData.hasOwnProperty('course')) this.course = courseData.course
  }

  setWooData (wooData) {
    this.wooData = wooData
    console.log('wooData', wooData)
  }
}
