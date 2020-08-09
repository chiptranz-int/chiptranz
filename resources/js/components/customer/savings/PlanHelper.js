/**
 * Created by MoFoLuWaSo on 10/1/2019.
 */
import React from 'react';

class PlanHelper {

    accountStatus(status) {
        switch (status) {
            case 0:
                return (<span className="text-right badge badge-info">Active</span>);
            case 1:
                return (<span className="text-right badge badge-warning">Muted</span>);
            case 2:
                return (<span className="text-right badge badge-danger">liquidated</span>);
            case 3:
                return (<span className="text-right badge badge-success">Completed</span>);
        }
    }


    savingsType(status) {
        switch (status) {
            case 0:
                return (<span className="text-right badge badge-success">Auto</span>);
            case 1:
                return (<span className="text-right badge badge-info">One-Time</span>);

        }
    }

    getPeriodicAmount(status, amount) {
        switch (status) {
            case 0:
                return amount;
            case 1:
                return 0;
            default:
                return amount;

        }
    }

    getFrequency(frequency) {
        switch (frequency) {
            case 1:
                return "Daily";
            case 2:
                return "Weekly";
            default:
                return "Monthly";

        }
    }

    filterDate(currentDate) {
        let date = new Date(currentDate);
        let stringDate = date.toDateString().split(" ");

        return stringDate[1] + " " + stringDate[2] + ", " + stringDate[3];
    }

    filterCard(card) {

        if (card.bank_name != null) {
            return card.bank_name + "-" + card.card_type +
                "-" + card.last_four_digit;
        } else {
            return "Card ending with " + card.last_four_digit;
        }

    }

    determineExpiryDate(card) {
        if (card.expiry_date != null) {
            let date = new Date(card.expiry_date);
            let stringDate = date.toDateString().split(" ");


            return "Expires ".stringDate[2] + " " + stringDate[3];
        }
        return '';

    }

    trimRefno(ref) {
        return ref.substr(0, 8) + "...";
    }


    savingsFrequency() {
        return [
            {id: '1', value: 'Daily'},

            {id: '2', value: 'Weekly'},

            {id: '3', value: 'Monthly'},
        ];

    }

    savingsAutomation() {


        return [
            {id: '0', value: 'Active'},

            {id: '1', value: 'Mute'},

        ];


    }

    gender() {


        return [
            {id: '0', value: 'Female'},

            {id: '1', value: 'Male'},

        ];


    }

    checkLiquidated(status) {
        if (status == '2' || status == '3' || status == '4') {
            return "disabled";
        } else {
            return " ";
        }

    }

    getTodaysDate() {
        let theDate = new Date();
        let year = theDate.getFullYear();
        let month = this.getFullDay(theDate.getMonth() + 1);
        let day = this.getFullDay(theDate.getDate());

        return year + "-" + month + "-" + day;
    }

    getFullDay(value) {

        if (value < 10) {
            return "0" + value;
        } else {
            return value;
        }
    }

    filterBank(code, banks) {
        let length = banks.length;

        for (let i = 0; i < length; i++) {
            if (banks[i].code == code) {
                return banks[i].name;
            }
        }
        return '';
    }

    getPlanName(plans, planType, planId) {


        let length = plans.length;

        for (let i = 0; i < length; i++) {

            if (plans[i].id == planId && plans[i].plan_type == planType) {
                return plans[i].plan_name;
            }
        }

        return '';
    }

    withdrawStatus(status) {
        switch (status) {
            case 0:
                return (<span className="text-right badge badge-warning text-white">Pending</span>);
            case 1:
                return (<span className="text-right badge badge-success">Successful</span>);
        }
    }


}


export default PlanHelper;