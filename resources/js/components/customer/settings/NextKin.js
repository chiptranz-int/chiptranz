/**
 * Created by MoFoLuWaSo on 9/21/2019.
 */
/**
 * Created by MoFoLuWaSo on 9/21/2019.
 */

import React, {Component} from 'react';
import Domain from '../../scalfolding/Domain.js';
import axios from 'axios';
import PlanHelper from '../savings/PlanHelper';

class NextKin extends Component {

    constructor(props) {
        super(props);
        this.state = {
            kin: {},
            view: 0,
            banks: [],
            message: '',


        };

        this.domain = new Domain();
        this.helper = new PlanHelper();
        this.retrieveUserKin = this.retrieveUserKin.bind(this);
        this.getView = this.getView.bind(this);
        this.sexInput = this.sexInput.bind(this);
        this.handlePlanChange = this.handlePlanChange.bind(this);
        this.getPersonalView = this.getPersonalView.bind(this);
        this.handleSubmit = this.handleSubmit.bind(this);
    }


    componentDidMount() {
        this.retrieveUserKin();
    }

    retrieveUserKin() {

        axios.get(this.domain.getDomain() + this.domain.getKinUrl()).then(function (response) {


            if (response.status == 200) {

                this.setState({
                    kin: response.data.kin,
                    banks: response.data.banks,

                });

            }


        }.bind(this));

    }

    handlePlanChange(e) {


        let property = e.target.getAttribute("itemid");
        let value = e.target.value;
        let oldPlan = this.state.kin;
        oldPlan[property] = value;

        this.setState({
            kin: oldPlan,
        });

    }

    sexInput(sex) {


        if (sex.id == this.state.kin.gender) {


            return (<label className="form-check-label">
                <input
                    type="radio"
                    defaultChecked="defaultChecked"
                    name="gender"
                    value={sex.id}
                    required="required"
                    itemID="gender"
                    onClick={this.handlePlanChange}
                    className="form-check-input"/>
                {sex.value}
                <i className="input-helper"></i>
            </label>);

        } else {
            return (<label className="form-check-label">
                <input
                    type="radio"
                    name="gender"
                    required="required"
                    value={sex.id}
                    itemID="gender"
                    onChange={this.handlePlanChange}
                    className="form-check-input"/>
                {sex.value}
                <i className="input-helper"></i>
            </label>);
        }
    }

    handleSubmit(e) {
        e.preventDefault();
        this.setState({
            message: 'Saving Next of Kin profile...'
        });

        let form = new FormData();

        form.append('name', this.state.kin.name);
        form.append('last_name', this.state.kin.last_name);
        form.append('telephone', this.state.kin.telephone);
        form.append('gender', this.state.kin.gender);
        form.append('email', this.state.kin.email);
        form.append('bank_name', this.state.kin.bank_name);
        form.append('bank_account', this.state.kin.bank_account);

        axios({
            method: 'post',
            url: this.domain.getDomain() + this.domain.getKinUrl(),
            data: form,
        }).then(function (response) {

            if (response.status == 200) {
                this.setState({
                    message:'Profile Saved Successfully!'
                });
            }

        }.bind(this));
    }

    getPersonalView() {


        return (
            <div>
                <div className="card">
                    <div className="card-body">
                        <div className="card-title"> Next of Kin</div>
                        <p className="text-info col-sm text-center ">{this.state.message}</p>
                        <form onSubmit={this.handleSubmit}>
                            <div className="row">
                                <div className="col-lg-6 col-md-6 col-sm-6">
                                    <p><b>Full Name</b>
                                        <br/>
                                        <span className="text-muted"><small>Enter full name of next of kin</small></span>
                                    </p>
                                </div>

                                <div className="col-lg-3 col-md-3 col-sm-6">
                                    <input defaultValue={this.state.kin.name} itemID="name"
                                           onChange={this.handlePlanChange}
                                           placeholder="First Name" required="required"
                                           className="form-control"/>
                                </div>
                                <div className="col-lg-3 col-md-3 col-sm-6">
                                    <input defaultValue={this.state.kin.last_name} itemID="last_name"
                                           onChange={this.handlePlanChange} required="required"
                                           placeholder="Last Name"
                                           className="form-control"/>
                                </div>
                            </div>
                            <br/>

                            <div className="row">
                                <div className="col-lg-6 col-md-6 col-sm-6">
                                    <p><b>Email Address</b>
                                        <br/>
                                        <span className="text-muted"><small>Email address of next of kin</small></span>
                                    </p>
                                </div>

                                <div className="col-lg-6 col-md-6 col-sm-6">
                                    <input type="email" defaultValue={this.state.kin.email} itemID="email"
                                           onChange={this.handlePlanChange} required="required"
                                           className="form-control"/>
                                </div>
                            </div>
                            <br/>

                            <div className="row">
                                <div className="col-lg-6 col-md-6 col-sm-6">
                                    <p><b>Telephone</b>
                                        <br/>
                                        <span className="text-muted"><small>Next of kin mobile number</small></span>
                                    </p>
                                </div>

                                <div className="col-lg-6 col-md-6 col-sm-6">
                                    <input defaultValue={this.state.kin.telephone} itemID="telephone"
                                           onChange={this.handlePlanChange} required="required"
                                           className="form-control"/>
                                </div>
                            </div>
                            <br/>

                            <div className="row">
                                <div className="col-lg-6 col-md-6 col-sm-6">
                                    <p><b>Bank Name</b>
                                        <br/>
                                        <span className="text-muted"><small>Next of kin's bank name</small></span>
                                    </p>
                                </div>

                                <div className="col-lg-6 col-md-6 col-sm-6">

                                    <select className="form-control" itemID="bank_name"

                                            value={this.state.kin.bank_name}
                                            onChange={this.handlePlanChange}>
                                        <option></option>
                                        {this.state.banks.map(function (bank) {
                                            return (
                                                <option key={bank.id}
                                                        value={bank.code}>{bank.name} </option>
                                            );
                                        }.bind(this))}

                                    </select>

                                </div>
                            </div>
                            <br/>
                            <div className="row">
                                <div className="col-lg-6 col-md-6 col-sm-6">
                                    <p><b>Bank Account Number</b>
                                        <br/>
                                        <span className="text-muted"><small>Next of kin's bank account number</small></span>
                                    </p>
                                </div>

                                <div className="col-lg-6 col-md-6 col-sm-6">
                                    <input defaultValue={this.state.kin.bank_account} itemID="bank_account"
                                           onChange={this.handlePlanChange}
                                           className="form-control"/>
                                </div>
                            </div>
                            <br/>

                            <div className="row mt-5">
                                <div className="col-lg-6 col-md-6 col-sm-6">
                                    <p><b>Gender</b>
                                        <br/>
                                        <span className="text-muted"><small>Next of kin's gender</small></span>
                                    </p>
                                </div>

                                <div className="col-lg-6 col-md-6 col-sm-6">
                                    <div className="row ml-2 ">
                                        {this.helper.gender().map(function (sex) {

                                            return (
                                                <div className="col-sm form-check" key={sex.id}>
                                                    {this.sexInput(sex)}
                                                </div>);
                                        }.bind(this))}

                                    </div>
                                </div>
                            </div>
                            <br/>


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
                return (
                    this.getPersonalView()
                );
        }

    }


    render() {

        return (
            <div>
                <nav aria-label="breadcrumb">
                    <ol className="breadcrumb">
                        <li className="breadcrumb-item "><a href="#">Settings</a></li>
                        <li className="breadcrumb-item active" aria-current="page">Next of Kin</li>
                    </ol>
                </nav>

                {this.getView()}
            </div>
        );

    }


}

export default NextKin;