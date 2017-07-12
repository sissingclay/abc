import { Injectable } from '@angular/core'

@Injectable()
export class AbDataProcessing {
  courseRadio (parentId, childId) {
    switch (parentId) {
      case '1':
        return ['19384', '19531', '19482', '19433'].indexOf(`${childId}`)
      case '2':
        return  ['19335', '19127', '19286', '19237'].indexOf(`${childId}`)
      case '3':
        return ['19127', '19286', '19237'].indexOf(`${childId}`)
      case '4':
        return ['19119', '19121', '19125'].indexOf(`${childId}`)
      case '5':
        return ['21106', '18907'].indexOf(`${childId}`)
      default:
        return false
    }
  }

  accomOptions (parentId, childId) {
    switch (parentId) {
      case '2':
        return ['19861', '19857', '19851', '19847'].indexOf(`${childId}`)
      case '3':
        return  ['19843', '19839', '19835', '19831'].indexOf(`${childId}`)
      case '4':
        return ['19829'].indexOf(`${childId}`)
      case '5':
        return ['19828'].indexOf(`${childId}`)
      case '6':
        return ['19827'].indexOf(`${childId}`)
      case '7':
        return ['21124'].indexOf(`${childId}`)
      default:
        return false
    }
  }

  getWeeks (startdate: string, enddate: string) {
    let startArr = startdate.split('/')
    let endArr = enddate.split('/')
    let first: any = new Date(`${startArr[2]}-${startArr[1]}-${startArr[0]}`)
    let second: any = new Date(`${endArr[2]}-${endArr[1]}-${endArr[0]}`)
    let days = Math.round((second - first) / (1000 * 60 * 60 * 24))
    let week_nos = Math.round(days / 7)
    return week_nos
  }
}