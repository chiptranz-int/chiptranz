/**
 * Created by MoFoLuWaSo on 9/21/2019.
 */
import React, {Component} from 'react';
import Domain from '../scalfolding/Domain.js';
import PlanHelper from './savings/PlanHelper';
import axios from 'axios';

class Summary extends Component {

    constructor(props) {

        super(props);


        this.state = {
            user: {},
            activity: {},
            activePlans: {},
            savingsHistory: {},
            savingsSummary: {},
        };

        this.domain = new Domain();
        this.helper = new PlanHelper();
        this.retrieveUserInfo = this.retrieveUserInfo.bind(this);
        this.activePlans = this.activePlans.bind(this);
        this.recentActivity = this.recentActivity.bind(this);
        this.savingsSummary = this.savingsSummary.bind(this);
    }

    componentDidMount() {

        this.retrieveUserInfo();
    }

    componentWillUnmount() {
        this.setState({
            user: {},
            activity: {},
            activePlans: {},
            savingsHistory: {},
        });
    }

    retrieveUserInfo() {

        axios.get(this.domain.getDomain() + this.domain.userSummary()).then(function (response) {


            if (response.status == 200) {

                this.setState({
                    user: response.data.user,
                    activity: response.data.activity,
                    savingsHistory: response.data.savingsHistory,
                    savingsSummary: response.data.savingsSummary,
                    activePlans: response.data.activePlans,
                });

            }


        }.bind(this));

    }

    recentActivity() {

        if (this.state.activity[0] != null) {
            return (
                <div className="col-md-8 col-lg-7 grid-margin ">
                    <div className="card">
                        <div className="card-body">
                            <div className="d-flex justify-content-between">
                                <h6 className="card-title">Recent Activity</h6>
                            </div>

                            <div className="list d-flex align-items-center border-bottom pb-3">

                                <div className="wrapper w-100 ml-3">
                                    <p><b>New Savings Plan set up </b></p>
                                    <p><b>Plan name </b>Housing</p>
                                    <small className="text-muted">2 hours ago</small>
                                </div>

                            </div>


                        </div>
                    </div>
                </div>

            );
        } else {

            return (


                <div className="col-md-8 col-lg-7 grid-margin ">
                    <div className="card">
                        <div className="card-body">
                            <p><b>No recent activity </b></p>
                        </div>
                    </div>
                </div>

            );

        }

    }

    savingsHistory() {

        if (this.state.savingsHistory[0] != null) {
            if (this.state.savingsHistory.length > 0) {
                return (
                    <div className="col-12">
                        <div className="card">
                            <div className="card-body">
                                <h4 className="card-title">Periodic Savings History</h4>

                                <div className="table-responsive mt-2">
                                    <table className="table mt-3 border-top">
                                        <thead>
                                        <tr>

                                            <th>Plan Name</th>
                                            <th>Amount Saved</th>
                                            <th>Reference number</th>
                                            <th>Date</th>
                                            <th>Type</th>

                                        </tr>
                                        </thead>
                                        <tbody>

                                        {this.state.savingsHistory.map(function (savings) {

                                            return (
                                                <tr key={savings.id}>

                                                    <td>{savings.plan_name}</td>
                                                    <td>{savings.amount_deposited}</td>
                                                    <td>{this.helper.trimRefno(savings.ref_no)}</td>
                                                    <td>{this.helper.filterDate(savings.date_deposited)}</td>
                                                    <td>{this.helper.savingsType(savings.deposit_type)}</td>

                                                </tr>
                                            );

                                        }.bind(this))

                                        }

                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>

                );
            }


        } else {

            return (
                <div className="col-12">
                    <div className="card">
                        <div className="card-body">
                            <h4 className="card-title">Savings History</h4>

                            <div className="table-responsive mt-2">
                                No Savings History
                            </div>

                        </div>
                    </div>
                </div>
            );
        }

    }

    quickLinks() {
        return (
            <div className="row">

                <div className="col-lg-4 grid-margin stretch-card">
                    <div className="card">
                        <div className="card-body">
                            <div className="d-flex justify-content-between">
                                <h6 className="card-title">Quick Links</h6>
                            </div>
                            <div className="list d-flex align-items-center border-bottom pb-3">
                                <img className="img-sm rounded-circle"
                                     src="../../images/faces/face8.jpg" alt=""/>
                                <div className="wrapper w-100 ml-3">
                                    <p><b>Open New Plan </b></p>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        );
    }

    activePlans() {

        if (this.state.activePlans[0] != null) {

            return (
                <div className="col-md-5 col-lg-5 grid-margin ">
                    <div className="card  bg-gradient-info">
                        <div className="card-body text-white">
                            <div className="d-flex justify-content-between">
                                <h6 className="card-title text-white">Active Plans</h6>
                            </div>

                            {this.state.activePlans.map(function (plan) {

                                return (
                                    <div key={plan.id} className="list d-flex align-items-center border-bottom pb-3">
                                        <div className="wrapper w-100 ml-3">
                                            <p><b>{plan.plan_name} </b></p>
                                            <p><b>Amount: </b>{plan.amounts}</p>
                                            <p><b>Start date: </b>{plan.start_date}</p>
                                            <p><b>Withdrawal date: </b>{plan.withdrawal_date}</p>
                                            <p><b>Frequency </b></p>
                                            <p><b>Total returns </b></p>
                                            <p><b>Total Savings </b></p>
                                            <p><b>Total Savings Balance </b></p>
                                            <p><b>Next Saving Date </b></p>

                                        </div>
                                    </div>
                                )

                            }.bind(this))}

                        </div>
                    </div>
                </div>
            );

        } else {

            return (
                <div className="col-md-5 col-lg-5 grid-margin ">
                    <div className="card  bg-gradient-info">
                        <div className="card-body text-white">
                            <div className="d-flex justify-content-between">
                                <h6 className="card-title text-white">Active Plans</h6>
                            </div>
                            <div className="list d-flex align-items-center border-bottom pb-3">

                                <div className="wrapper w-100 ml-3">
                                    <p><b>No active plans </b></p>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            );
        }
    }

    savingsSummary() {
        return (
            <div className="row ">
                <div className="col-md-6 col-lg-3 grid-margin stretch-card">
                    <div className="card bg-gradient-info text-white text-center card-shadow-primary">
                        <div className="card-body">
                            <h6 className="font-weight-normal">Total Balance</h6>
                            <h2 className="mb-0">{this.state.savingsSummary.balance}</h2>
                        </div>
                    </div>
                </div>
                <div className="col-md-6 col-lg-3 grid-margin stretch-card">
                    <div className="card bg-gradient-primary text-white text-center card-shadow-danger">
                        <div className="card-body">
                            <h6 className="font-weight-normal">Total Savings</h6>
                            <h2 className="mb-0">{this.state.savingsSummary.savings}</h2>
                        </div>
                    </div>
                </div>
                <div className="col-md-6 col-lg-3 grid-margin stretch-card">
                    <div className="card bg-gradient-warning text-white text-center card-shadow-warning">
                        <div className="card-body">
                            <h6 className="font-weight-normal">Total Returns</h6>
                            <h2 className="mb-0">{this.state.savingsSummary.returns}</h2>
                        </div>
                    </div>
                </div>

                <div className="col-md-6 col-lg-3 grid-margin stretch-card">
                    <div className="card bg-gradient-danger text-white text-center card-shadow-warning">
                        <div className="card-body">
                            <h6 className="font-weight-normal">Total Withdrawals</h6>
                            <h2 className="mb-0">{this.state.savingsSummary.withdrawals}</h2>
                        </div>
                    </div>
                </div>


            </div>
        );
    }

    render() {
        return (<div>
            <nav aria-label="breadcrumb">
                <ol className="breadcrumb">
                    <li className="breadcrumb-item active"><a href="#">Summary</a></li>
                </ol>
            </nav>
            <div className="row">
                <div className="col-md-6 col-lg-6 ">
                    <h2> {this.state.user.name ? 'Welcome ' + this.state.user.name + ',' : ''}</h2>
                </div>

            </div>


            {this.savingsSummary()}


            <div className="row grid-margin">
                {this.savingsHistory()}
            </div>


        </div>)
    }


}


export default Summary;