/**
 * Created by MoFoLuWaSo on 9/21/2019.
 */
/**
 * Created by MoFoLuWaSo on 9/21/2019.
 */
import React, {Component} from 'react';
import Domain from '../../scalfolding/Domain.js';
import axios from 'axios';
import  {Router, Route, Link} from 'react-router-dom';

import PlanOptionsModal from './PlanOptionsModal';

import PlanHelper from './PlanHelper';

import ChipLoader from '../../ChipLoader';

class YouthGoals extends Component {

    constructor(props) {
        super(props);
        this.state = {
            user: {},
            youth: {},
            show: false,
            currentPlan: {},
            view: 0,
            youthSavings: [],
            message: '',


        };

        this.domain = new Domain();
        this.helper = new PlanHelper();
        this.getPlanView = this.getPlanView.bind(this);
        this.handleClose = this.handleClose.bind(this);
        this.handleOpen = this.handleOpen.bind(this);
        this.getView = this.getView.bind(this);
        this.handleMainView = this.handleMainView.bind(this);
        this.handleOverview = this.handleOverview.bind(this);
        this.handlePlanSettings = this.handlePlanSettings.bind(this);
        this.retrieveYouthSavings = this.retrieveYouthSavings.bind(this);
        this.handlePlanChange = this.handlePlanChange.bind(this);
        this.frequencyInput = this.frequencyInput.bind(this);
        this.automatedInput = this.automatedInput.bind(this);
        this.handleSubmit = this.handleSubmit.bind(this);
        this.getSettingsView = this.getSettingsView.bind(this);


    }


    componentDidMount() {
        this.retrieveUserInfo();
    }

    retrieveUserInfo() {

        axios.get(this.domain.getDomain() + this.domain.youthPlan()).then(function (response) {


            if (response.status == 200) {

                this.setState({
                    user: response.data.user,
                    youth: response.data.youth,
                    cards: response.data.cards,

                });

            }


        }.bind(this));

    }

    retrieveYouthSavings() {
        axios.get(this.domain.getDomain() + this.domain.youthSavings(this.state.currentPlan.id)).then(function (response) {


            if (response.status == 200) {

                this.setState({

                    youthSavings: response.data.youthSavings,

                });

            }


        }.bind(this));
    }


    handleClose() {
        this.setState({
            show: false,
        });
    }

    handleOpen(plan) {


        this.setState({
            show: true,
            currentPlan: plan,
        });
    }

    handleOverview() {
        this.setState({
            view: 1,
            show: false,

        });
        this.retrieveYouthSavings();

    }

    handlePlanSettings() {
        this.setState({
            view: 2,
            show: false,
        });
    }

    handleMainView() {
        this.setState({
            view: 0,

        });
    }

    handlePlanChange(e) {


        let property = e.target.getAttribute("itemid");
        let value = e.target.value;
        let oldPlan = this.state.currentPlan;
        oldPlan[property] = value;

        this.setState({
            currentPlan: oldPlan,
        });

    }

    handleSubmit(e) {
        e.preventDefault();


        let form = new FormData();
        form.append('id', this.state.currentPlan.id);
        form.append('user_id', this.state.currentPlan.user_id);
        form.append('plan_name', this.state.currentPlan.plan_name);
        form.append('amounts', this.state.currentPlan.amounts);
        form.append('frequency', this.state.currentPlan.frequency);
        form.append('status', this.state.currentPlan.status);
        form.append('next_savings', this.state.currentPlan.next_savings);
        form.append('transact_id', this.state.currentPlan.transact_id);


        axios({
            method: 'post',
            url: this.domain.getDomain() + this.domain.updateYouthGoals(),
            data: form,
        }).then(function (response) {
            this.setState({
                message: 'Settings Saved Successfully'
            });

        }.bind(this));

    }


    getPlanView() {

        if (this.state.youth[0] != null) {


            return (


                <div className="col-12 row">

                    {this.state.youth.map(function (plan) {
                        return (
                            <div key={plan.id} className="card col-lg-5 col-md-5 mb-2 ml-1">
                                <div className="card-body">
                                    <h4 className="card-title">{plan.plan_name} {this.helper.accountStatus(plan.status)}</h4>
                                    <div className="row">
                                        <div className="col-lg-6 col-md-6">

                                            <p>Balance</p>
                                            <p>&#x20A6; <b className="h3">{plan.total_saved.toLocaleString()}</b></p>
                                        </div>
                                        <div className="col-lg-6 col-md-6 text-right">
                                            <p>Annual interest rate </p>
                                            <p className="text-primary  h3"><b>{plan.interest_rate}% </b></p>

                                        </div>
                                    </div>
                                    <br />
                                    <div className="row">
                                        <div className="col-lg-8">
                                            <p>Next saving date: <b> {plan.next_save} </b></p>
                                        </div>


                                        <div className="">

                                            <button onClick={() => this.handleOpen(plan)}
                                                    className="btn btn-sm btn-outline-primary ">Plan Options
                                            </button>

                                        </div>
                                    </div>


                                </div>
                            </div>

                        );

                    }.bind(this))}

                </div>);
        } else {
            return (

                <div className="col-12">


                    <div className="row">
                        <div className="col-lg-4">

                        </div>
                        <div className="col-lg-5">
                            <button className="btn btn-primary btn-lg">New Goal</button>
                        </div>
                    </div>
                </div>

            );
        }
    }


    getSummaryView() {

        return (

            <div>
                Overview

                <div className="row">

                    <div className="card grid-margin col-lg-4 col-md-5  mr-2">
                        <div className="card-body">
                            <div className="card-title">{this.state.currentPlan.plan_name}</div>
                            <div>
                                <p>Balance</p>
                                <p>&#x20A6; <b className="h4">{this.state.currentPlan.total_saved}</b></p>
                                <p>Periodic amount:
                                    <b> &#x20A6; {this.helper.getPeriodicAmount(this.state.currentPlan.status, this.state.currentPlan.amounts)}</b>
                                </p>
                            </div>
                            <br />
                            <div className="row">

                                <div className="col-lg-6 col-md-6 col-sm-6">
                                    <p>Frequency</p>
                                    <p><b>{this.helper.getFrequency(this.state.currentPlan.frequency)}</b></p>
                                </div>
                                <div className="col-lg-6 col-md-6 col-sm-6">
                                    <p>Status</p>
                                    <p><b>{this.helper.accountStatus(this.state.currentPlan.status)}</b></p>
                                </div>
                            </div>
                            <br />
                            <div className="row">

                                <div className="col-lg-6 col-md-6 col-sm-6">
                                    <p>Start Date</p>
                                    <p><b>{this.helper.filterDate(this.state.currentPlan.start_date)}</b></p>
                                </div>
                                <div className="col-lg-6 col-md-6 col-sm-6">
                                    <p>Withdrawal Date</p>
                                    <p><b>{this.helper.filterDate(this.state.currentPlan.withdrawal_date)}</b></p>
                                </div>
                            </div>
                            <br />
                            <div className="row">

                                <div className="col-lg-6 col-md-6 col-sm-6">
                                    <p>Next saving date</p>
                                    <p><b>{this.helper.filterDate(this.state.currentPlan.next_save)}</b></p>
                                </div>
                                <div className="col-lg-6 col-md-6 col-sm-6">
                                    <p>Card on Plan</p>
                                    <p><b>{this.helper.filterCard(this.state.currentPlan.plan_card)}</b></p>
                                </div>
                            </div>

                        </div>

                    </div>

                    <div className="card col-lg-7 col-md-6 grid-margin overflow-auto p-3">

                        <div className="table-responsive">
                            <table className="table table-striped table-sm">
                                <thead>
                                <tr>
                                    <th colSpan="2">
                                        Savings Records
                                    </th>

                                    <th>
                                        Amount
                                    </th>
                                    <th>
                                        Date
                                    </th>
                                    <th>
                                        Type
                                    </th>
                                    <th>
                                        Reference
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                {this.state.youthSavings.map(function (savings) {

                                    return (

                                        <tr key={savings.id}>
                                            <td className="" colSpan="2">
                                                {this.state.currentPlan.plan_name}
                                            </td>
                                            <td>
                                                &#x20A6;{savings.amount_deposited}
                                            </td>
                                            <td>
                                                {this.helper.filterDate(savings.date_deposited)}
                                            </td>
                                            <td>
                                                {this.helper.savingsType(savings.deposit_type)}
                                            </td>
                                            <td>
                                                {this.helper.trimRefno(savings.ref_no)}
                                            </td>
                                        </tr>
                                    );

                                }.bind(this))}


                                </tbody>
                            </table>
                        </div>


                    </div>

                </div>

            </div>


        );


    }

    frequencyInput(frequency) {

        if (frequency.id == this.state.currentPlan.frequency) {


            return (<label className="form-check-label">
                <input
                    type="radio"
                    defaultChecked="defaultChecked"
                    name="frequency"
                    value={frequency.id}
                    itemID="frequency"
                    onClick={this.handlePlanChange}
                    className="form-check-input"/>
                {frequency.value}
                <i className="input-helper"></i>
            </label>);

        } else {
            return (<label className="form-check-label">
                <input
                    type="radio"
                    name="frequency"
                    value={frequency.id}
                    itemID="frequency"
                    onClick={this.handlePlanChange}
                    className="form-check-input"/>
                {frequency.value}
                <i className="input-helper"></i>
            </label>);
        }
    }

    automatedInput(auto) {

        if (auto.id == this.state.currentPlan.status) {


            return (<label className="form-check-label">
                <input
                    type="radio"
                    defaultChecked="defaultChecked"
                    name="status"
                    value={auto.id}
                    itemID="status"
                    onClick={this.handlePlanChange}
                    className="form-check-input"/>
                {auto.value}
                <i className="input-helper"></i>
            </label>);

        } else {
            return (<label className="form-check-label">
                <input
                    type="radio"
                    name="status"
                    value={auto.id}
                    itemID="status"
                    onChange={this.handlePlanChange}
                    className="form-check-input"/>
                {auto.value}
                <i className="input-helper"></i>
            </label>);
        }
    }


    getSettingsView() {

        return (
            <div>
                <div className="card">
                    <div className="card-body">
                        <div className="card-title"> Plan Settings</div>
                        <p className="text-success">{this.state.message}</p>
                        <form onSubmit={this.handleSubmit}>
                            <div className="row">
                                <div className="col-lg-6 col-md-6 col-sm-6">
                                    <p><b>Plan Name</b>
                                        <br />
                                        <span className="text-muted"><small>Give your plan a new name</small></span>
                                    </p>
                                </div>

                                <div className="col-lg-6 col-md-6 col-sm-6">
                                    <input value={this.state.currentPlan.plan_name} itemID="plan_name"
                                           onChange={this.handlePlanChange}
                                           className="form-control"/>
                                </div>
                            </div>
                            <br />

                            <div className="row">
                                <div className="col-lg-6 col-md-6 col-sm-6">
                                    <p><b>Periodic Amount</b>
                                        <br />
                                        <span className="text-muted"><small>Change how much you save into this plan</small></span>
                                    </p>
                                </div>

                                <div className="col-lg-6 col-md-6 col-sm-6">
                                    <input type="number" value={this.state.currentPlan.amounts} itemID="amounts"
                                           onChange={this.handlePlanChange}
                                           className="form-control"/>
                                </div>
                            </div>
                            <br />

                            <div className="row">
                                <div className="col-lg-6 col-md-6 col-sm-6">
                                    <p><b>Savings Frequency</b>
                                        <br />
                                        <span className="text-muted"><small>Change how often you save into this plan</small></span>
                                    </p>
                                </div>

                                <div className="col-lg-6 col-md-6 col-sm-6">
                                    <div className="row ml-2 ">
                                        {this.helper.savingsFrequency().map(function (frequency) {

                                            return (
                                                <div className="col-sm form-check" key={frequency.id}>
                                                    {this.frequencyInput(frequency)}

                                                </div>);
                                        }.bind(this))}

                                    </div>
                                </div>
                            </div>
                            <br />

                            <div className="row mt-5">
                                <div className="col-lg-6 col-md-6 col-sm-6">
                                    <p><b>Plan Automation</b>
                                        <br />
                                        <span className="text-muted"><small>Automate or mute savings for your plan</small></span>
                                    </p>
                                </div>

                                <div className="col-lg-6 col-md-6 col-sm-6">
                                    <div className="row ml-2 ">
                                        {this.helper.savingsAutomation().map(function (auto) {

                                            return (
                                                <div className="col-sm form-check" key={auto.id}>
                                                    {this.automatedInput(auto)}
                                                </div>);
                                        }.bind(this))}

                                    </div>
                                </div>
                            </div>
                            <br />


                            <div className="row">
                                <div className="col-lg-6 col-md-6 col-sm-6">
                                    <p><b>Next Saving Date</b>
                                        <br />
                                        <span className="text-muted"><small>Modify your next saving date</small></span>
                                    </p>
                                </div>

                                <div className="col-lg-6 col-md-6 col-sm-6">
                                    <input type="date" value={this.state.currentPlan.next_savings}
                                           min={this.helper.getTodaysDate()} itemID="next_savings"
                                           onChange={this.handlePlanChange}
                                           className="form-control"/>
                                </div>
                            </div>
                            <br />
                            <div className="row">
                                <div className="col-lg-6 col-md-6 col-sm-6">
                                    <p><b>Payment Choice</b>
                                        <br />
                                        <span className="text-muted"><small>Select a debit card for your plan</small></span>
                                    </p>
                                </div>

                                <div className="col-lg-6 col-md-6 col-sm-6">
                                    <select className="form-control" itemID="transact_id"

                                            defaultValue={this.state.currentPlan.transact_id}
                                            onChange={this.handlePlanChange}>
                                        <option></option>
                                        {this.state.cards.map(function (card) {
                                            return (
                                                <option key={card.id}
                                                        value={card.id}>{this.helper.filterCard(card)} </option>
                                            );
                                        }.bind(this))}

                                    </select>
                                </div>
                            </div>

                            <div className="text-center mt-4">
                                <button type="submit" className=" btn btn-primary mb-2">Save</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        );

    }

    getView() {
        switch (this.state.view) {
            case 0:
                return (this.getPlanView());
            case 1:
                return (this.getSummaryView());
            case 2:
                return (this.getSettingsView());
            default:
                return (<ChipLoader />);


        }
    }

    getMainViewButton() {
        if (this.state.view != 0) {
            return (<button onClick={this.handleMainView} className="float-right btn btn-sm btn-outline-primary">Back to
                Youth Goals</button>);
        }
    }


    render() {

        return (


            <div>
                {this.getMainViewButton()}
                <nav aria-label="breadcrumb">
                    <ol className="breadcrumb">
                        <li className="breadcrumb-item "><a href="#">Savings</a></li>
                        <li className="breadcrumb-item active" aria-current="page">Youth Goals</li>
                    </ol>

                </nav>

                <PlanOptionsModal
                    show={this.state.show}
                    handleClose={this.handleClose}
                    onHide={this.handleClose}
                    handleOverview={this.handleOverview}
                    handlePlanSettings={this.handlePlanSettings}
                />


                {this.getView()}


            </div>
        );

    }


}

export default YouthGoals;