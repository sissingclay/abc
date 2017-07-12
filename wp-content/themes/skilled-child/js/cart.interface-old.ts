export interface CartInterface {
	"course": object {
		"back_getProductOption": string
		"back_productid": string
		"back_coursestartdate": Date
		"back_courseweek": string
		"back_course_level": string
		"back_productidpop": string,
		"ex": string
	},
	"accommodation": object {
		"back_accomdation": string
		"back_meal_plan": string
		"back_product_acc_zone": string
		"back_accomodation_week": string
		"back_acc_startdate": Date
		"back_acc_enddate": Date
		"back_acc_supplement": string
		"back_smoke": string
		"back_petbother": string
		"back_allergies": string
		"back_allergiestype": string
		"back_bathroom": string
		"back_transport_type": string
		"back_flightname": string
		"back_arrivaldate": Date
		"back_departuredate": string
		"back_visa_require": string
	},
	"fee_charge": string
	"click_back": string
}

const test = {
	"course": {
		"back_getProductOption": "1",
		"back_productid": null,
		"back_coursestartdate": "21\/07\/2017",
		"back_courseweek": "5-weeks",
		"back_course_level": "a2-elementary",
		"back_productidpop": "19482"
	},
	"accommodation": {
		"back_accomdation": "2",
		"back_meal_plan": "19861",
		"back_product_acc_zone": "zone-1-2",
		"back_accomodation_week": "5",
		"back_acc_startdate": "15\/07\/2017",
		"back_acc_enddate": "26\/08\/2017",
		"back_acc_supplement": "yes",
		"back_smoke": "Yes",
		"back_petbother": "",
		"back_allergies": "Do you have Allergies?",
		"back_allergiestype": "",
		"back_bathroom": "yes",
		"back_transport_type": "17559",
		"back_flightname": "dsdfs",
		"back_arrivaldate": "07\/29\/2017",
		"back_departuredate": "08:00 PM",
		"back_visa_require": "19871"
	},
	"fee_charge": "no",
	"click_back": "back_click"
}
