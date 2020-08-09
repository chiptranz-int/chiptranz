/**
 * Created by MoFoLuWaSo on 9/21/2019.
 */

import React, {Component} from 'react';
import  {Router, Route, Link} from 'react-router-dom';
import Domain from '../../scalfolding/Domain.js';
import {createBrowserHistory} from 'history';
import YouthPlan from '../new-plan/YouthPlan';
import SteadyPlan from '../new-plan/SteadyPlan';

class PlanOptions extends Component {

    constructor(props) {
        super(props);

        this.titleStyle = {
            width: 150,
        };

        this.state = {
            page: 0,
            user:{},
        };

        this.domain = new Domain();

        this.handleHome = this.handleHome.bind(this);
        this.handlePage = this.handlePage.bind(this);
        this.getPage = this.getPage.bind(this);

    }

    componentDidMount(){
        if(this.props.user){
            this.setState({
                user: this.props.user,
            })
        }
    }


    handleHome() {
        window.location = this.domain.getDomain();
    }

    handlePage(e) {
        this.setState({
            page: parseInt(e.target.getAttribute("itemid")),
        });


    }

    getPage() {
        switch (this.state.page) {

            case 1:
                return (<YouthPlan user={this.state.user} />);

            case 2:
                return (<SteadyPlan user={this.state.user} />);
            default:

                return (

                    <div>

                        <div className="content-wrapper ">

                            <div className="container">
                                <div className="row">
                                    <div className="card  col-lg-12 col-md-12 grid-margin ">

                                        <div className="card text-dark  card-shadow-primary">

                                            <div className="card-body">
                                                <div className="float-right"><Link to='/home' >
                                                    <button
                                                            className="btn btn-sm btn-outline-info">Back
                                                    </button>
                                                </Link></div>
                                                <div className="brand-logo">
                                                    <img src={`../chiptranz-vendors/images/logo.svg `} alt="logo"
                                                         style={this.titleStyle}/>
                                                </div>

                                                <br />

                                                <h2>Hello {this.state.user.name},</h2>
                                                <p className="h4 font-weight-normal">Select a Plan to continue</p>

                                            </div>

                                        </div>
                                    </div>


                                </div>

                                <div className="row">
                                    <div className="col-lg-2"></div>
                                    <div className="col-lg-4 grid-margin stretch-card">
                                        <div className="card">
                                            <div className="card-body">
                                                <div className="d-flex justify-content-between">
                                                    <h3 className="card-title"><i
                                                        className="fa fa-users text-primary fa-2x"></i> Youth Goals</h3>
                                                </div>
                                                <div className="list d-flex align-items-center border-bottom pb-3">

                                                    <div className="wrapper w-100 ml-3">
                                                        <p><b>10% Interest per annum </b></p>

                                                    </div>
                                                </div>
                                                <div className="list d-flex align-items-center border-bottom py-3">

                                                    <div className="wrapper w-100 ml-3">
                                                        <p><b>Flexible savings plan</b></p>

                                                    </div>
                                                </div>
                                                <div className="list d-flex align-items-center border-bottom py-3">

                                                    <div className="wrapper w-100 ml-3">
                                                        <p><b>Liquidation after 3 months </b></p>

                                                    </div>
                                                </div>
                                                <div
                                                    className="list text-center d-flex align-items-center border-bottom py-3">

                                                    <div className="wrapper w-100 ml-3">

                                                        <button data="1" onClick={this.handlePage} itemID="1"
                                                                className="btn btn-lg btn-info">Start Plan
                                                        </button>

                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div className="col-lg-4 grid-margin stretch-card">
                                        <div className="card">
                                            <div className="card-body">
                                                <div className="d-flex justify-content-between">
                                                    <h3 className="card-title"><i
                                                        className="fa fa-calendar text-success fa-2x"></i> Steady Growth
                                                    </h3>
                                                </div>
                                                <div className="list d-flex align-items-center border-bottom pb-3">

                                                    <div className="wrapper w-100 ml-3">
                                                        <p><b>10%-15% Interest per annum </b></p>

                                                    </div>
                                                </div>
                                                <div className="list d-flex align-items-center border-bottom py-3">

                                                    <div className="wrapper w-100 ml-3">
                                                        <p><b>Fixed savings plan</b></p>

                                                    </div>
                                                </div>
                                                <div className="list d-flex align-items-center border-bottom py-3">

                                                    <div className="wrapper w-100 ml-3">
                                                        <p><b>Liquidation after 6 months </b></p>

                                                    </div>
                                                </div>
                                                <div
                                                    className="list text-center d-flex align-items-center border-bottom py-3">

                                                    <div className="wrapper w-100 ml-3">
                                                        <button data="2" onClick={this.handlePage} itemID="2"
                                                                className="btn btn-lg btn-success">Start Plan
                                                        </button>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>




                );

        }
    }

    render() {
        return this.getPage();


    }


}

export default PlanOptions;