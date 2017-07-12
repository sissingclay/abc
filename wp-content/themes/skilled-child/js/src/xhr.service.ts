import { Injectable } from '@angular/core'
import { Http, Response, RequestOptions, Headers } from '@angular/http'

import { Observable } from 'rxjs/Observable'
import 'rxjs/add/operator/catch'
import 'rxjs/add/operator/map'
import 'rxjs/add/observable/from'
import 'rxjs/add/observable/throw'
import 'rxjs/add/operator/distinctUntilChanged'
import 'rxjs/add/operator/switchMap'

@Injectable()
export class GenericService {
	private headers = new Headers({ 'Content-Type': 'application/x-www-form-urlencoded' })
	private options = new RequestOptions({  headers: this.headers })
  constructor (private http: Http) {}

  getJsonData (endpoint: string) {
    return this.http.get(endpoint)
      .map(this.extractResult)
			.catch(this.handleError)
  }

	saveData (endpoint, postData: any, json = true) {
		let request = (json) ? this.extractResultJson : this.extractResult
		return this.http.post(`${endpoint}`, postData, this.options)
			.map(request)
			.catch(this.handleError)
	}

	extractResultJson (res: Response) {
		let body = res.json()
		return body || {}
	}

  extractResult (res: Response) {
		return {}
	}

	handleError (error: Response | any) {
    console.log('error', error)
		if (error.status >= 500) {
		} else {
			let err = error.json()
			if (err && err.message) {
				
			}
		}
		return Observable.throw('Error')
	}
}
