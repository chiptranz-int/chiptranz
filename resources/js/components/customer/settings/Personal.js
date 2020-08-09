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

class Personal extends Component {

    constructor(props) {
        super(props);
        this.state = {
            user: {},
            view: 0,
            message: '',


        };

        this.domain = new Domain();
        this.helper = new PlanHelper();
        this.retrieveUserInfo = this.retrieveUserInfo.bind(this);
        this.getView = this.getView.bind(this);
        this.sexInput = this.sexInput.bind(this);
        this.handlePlanChange = this.handlePlanChange.bind(this);
        this.getPersonalView = this.getPersonalView.bind(this);
        this.handleSubmit = this.handleSubmit.bind(this);
    }


    componentDidMount() {
        this.retrieveUserInfo();
    }

    retrieveUserInfo() {

        axios.get(this.domain.getDomain() + this.domain.getUserUrl()).then(function (response) {


            if (response.status == 200) {

                this.setState({
                    user: response.data,

                });

            }


        }.bind(this));

    }

    handlePlanChange(e) {


        let property = e.target.getAttribute("itemid");
        let value = e.target.value;
        let oldPlan = this.state.user;
        oldPlan[property] = value;

        this.setState({
            user: oldPlan,
        });

    }

    sexInput(sex) {


        if (sex.id == this.state.user.gender) {


            return (<label className="form-check-label">
                <input
                    type="radio"
                    defaultChecked="defaultChecked"
                    name="gender"
                    value={sex.id}
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
            message: 'Saving your profile...'
        });

        let form = new FormData();
        form.append('id', this.state.user.id);
        form.append('name', this.state.user.name);
        form.append('last_name', this.state.user.last_name);
        form.append('telephone', this.state.user.telephone);
        form.append('gender', this.state.user.gender);
        form.append('birth_date', this.state.user.birth_date);

        axios({
            method: 'post',
            url: this.domain.getDomain() + this.domain.getUserUrl(),
            data: form,
        }).then(function (response) {

            if (response.status == 200) {
                this.setState({
                    message: 'Profile Saved Successfully!'
                });
            }

        }.bind(this));

    }

    getPersonalView() {

        return (
            <div>
                <div className="card">
                    <div className="card-body">
                        <div className="card-title"> Personal</div>
                        <p className="text-info col-sm text-center ">{this.state.message}</p>
                        <form onSubmit={this.handleSubmit}>
                            <div className="row">
                                <div className="col-lg-6 col-md-6 col-sm-6">
                                    <p><b>Full Name</b>
                                        <br/>
                                        <span className="text-muted"><small>Edit your full name</small></span>
                                    </p>
                                </div>

                                <div className="col-lg-3 col-md-3 col-sm-6">
                                    <input defaultValue={this.state.user.name} itemID="name"
                                           onChange={this.handlePlanChange}

                                           placeholder="First Name"
                                           className="form-control"/>
                                </div>
                                <div className="col-lg-3 col-md-3 col-sm-6">
                                    <input defaultValue={this.state.user.last_name} itemID="last_name"
                                           onChange={this.handlePlanChange}
                                           placeholder="Last Name"
                                           className="form-control"/>
                                </div>
                            </div>
                            <br/>


                            <div className="row">
                                <div className="col-lg-6 col-md-6 col-sm-6">
                                    <p><b>Telephone</b>
                                        <br/>
                                        <span className="text-muted"><small>Mobile number to receive sms</small></span>
                                    </p>
                                </div>

                                <div className="col-lg-6 col-md-6 col-sm-6">
                                    <input defaultValue={this.state.user.telephone} itemID="telephone"
                                           onChange={this.handlePlanChange}
                                           className="form-control"/>
                                </div>
                            </div>
                            <br/>

                            <div className="row mt-5">
                                <div className="col-lg-6 col-md-6 col-sm-6">
                                    <p><b>Gender</b>
                                        <br/>
                                        <span className="text-muted"><small>Enter your gender</small></span>
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
                            <div className="row mt-5">
                                <div className="col-lg-6 col-md-6 col-sm-6">
                                    <p><b>Date of Birth</b>
                                        <br/>
                                        <span className="text-muted"><small>Enter your date of birth</small></span>
                                    </p>
                                </div>

                                <div className="col-lg-6 col-md-6 col-sm-6">
                                    <div className="row ml-2 ">
                                        <input defaultValue={this.state.user.birth_date} itemID="birth_date"
                                               onChange={this.handlePlanChange}
                                               type="date"
                                               placeholder="Date of Birth"
                                               className="form-control"/>

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
        if (this.state.user != 'undefined') {
            switch (this.state.view) {
                case 0:
                    return (
                        this.getPersonalView()
                    );
            }
        }
    }


    render() {

        return (
            <div>
                <nav aria-label="breadcrumb">
                    <ol className="breadcrumb">
                        <li className="breadcrumb-item "><a href="#">Settings</a></li>
                        <li className="breadcrumb-item active" aria-current="page">Personal</li>
                    </ol>
                </nav>

                {this.getView()}
            </div>
        );

    }


}

export default Personal;