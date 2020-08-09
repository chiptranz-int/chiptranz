/**
 * Created by MoFoLuWaSo on 9/21/2019.
 */
import React, {Component} from 'react';
import Domain from "../scalfolding/Domain";
import PlanHelper from "./savings/PlanHelper";
import axios from "axios";
import WithdrawalModal from "./WithdrawalModal";


class Withdrawal extends Component {

    constructor(props) {
        super(props);
        this.state = {
            user: {},
            plan_id: '',
            plan_type: '',
            amount: 1,
            view: 0,
            balance: '',
            accountMessage: '',
            requestType: 0,
            bank: {},
            show: false,
            toRemove: {},
            plans: [],
            steadyWithdrawals: [],
            youthWithdrawals: [],


        };

        this.domain = new Domain();
        this.helper = new PlanHelper();
        this.retrieveUserInfo = this.retrieveUserInfo.bind(this);
        this.getYouthWithdrawals = this.getYouthWithdrawals.bind(this);
        this.getSteadyWithdrawals = this.getSteadyWithdrawals.bind(this);
        this.withdrawalView = this.withdrawalView.bind(this);
        this.handleMakeWithdrawal = this.handleMakeWithdrawal.bind(this);
        this.handleClose = this.handleClose.bind(this);
        this.nextView = this.nextView.bind(this);
        this.previous = this.previous.bind(this);
        this.handlePlanChange = this.handlePlanChange.bind(this);
        this.handleRequestChange = this.handleRequestChange.bind(this);
        this.handleAmountChange = this.handleAmountChange.bind(this);
        this.initiateWithdrawal = this.initiateWithdrawal.bind(this);


    }


    componentDidMount() {
        this.retrieveUserInfo();
    }

    retrieveUserInfo() {

        axios.get(this.domain.getDomain() + this.domain.userWithdrawals()).then(function (response) {


            if (response.status == 200) {

                this.setState({

                    user: response.data.user,
                    plans: response.data.plans,
                    bank: response.data.bank,
                    steadyWithdrawals: response.data.steadyWithdrawals,
                    youthWithdrawals: response.data.youthWithdrawals,

                });

            }


        }.bind(this));

    }

    getYouthWithdrawals() {
        if (this.state.youthWithdrawals.length > 0) {
            return (
                <div className="card col-lg-7 col-md-6 grid-margin overflow-auto p-3">
                    <div className="card-title">Youth Withdrawals</div>
                    <div className="table-responsive">
                        <table className="table table-striped table-sm">
                            <thead>
                            <tr>
                                <th colSpan="2">
                                    Plan Name
                                </th>

                                <th>
                                    Amount
                                </th>
                                <th>
                                    Date
                                </th>
                                <th>
                                    Reference

                                </th>
                                <th>
                                    Status
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            {this.state.youthWithdrawals.map(function (withdraw) {

                                return (

                                    <tr key={withdraw.id}>
                                        <td className="" colSpan="2">
                                            {this.helper.getPlanName(this.state.plans, 0, withdraw.plan_id)}
                                        </td>
                                        <td>
                                            &#x20A6;{withdraw.amount}
                                        </td>
                                        <td>
                                            {this.helper.filterDate(withdraw.withdraw_date)}
                                        </td>
                                        <td>
                                            {this.helper.trimRefno(withdraw.reference)}
                                        </td>
                                        <td>
                                            {this.helper.withdrawStatus(withdraw.status)}
                                        </td>
                                    </tr>
                                );

                            }.bind(this))}

                            </tbody>
                        </table>
                    </div>
                </div>
            )
        } else {
            return (<div className="card col-lg-7 col-md-6 grid-margin overflow-auto p-3">
                You have not made any withdrawal from your youth goal
            </div>);
        }


    }

    getSteadyWithdrawals() {
        if (this.state.steadyWithdrawals.length > 0) {
            return (
                <div className="card col-lg-7 col-md-6 grid-margin overflow-auto p-3">
                    <div className="card-title">Steady Withdrawals</div>
                    <div className="table-responsive">
                        <table className="table table-striped table-sm">
                            <thead>
                            <tr>
                                <th colSpan="2">
                                    Plan Name
                                </th>

                                <th>
                                    Amount
                                </th>
                                <th>
                                    Date
                                </th>
                                <th>
                                    Reference

                                </th>
                                <th>
                                    Status
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            {this.state.steadyWithdrawals.map(function (withdraw) {

                                return (

                                    <tr key={withdraw.id}>
                                        <td className="" colSpan="2">
                                            {this.helper.getPlanName(this.state.plans, 1, withdraw.plan_id)}
                                        </td>
                                        <td>
                                            &#x20A6;{withdraw.amount}
                                        </td>
                                        <td>
                                            {this.helper.filterDate(withdraw.withdraw_date)}
                                        </td>
                                        <td>
                                            {this.helper.trimRefno(withdraw.reference)}
                                        </td>
                                        <td>
                                            {this.helper.withdrawStatus(withdraw.status)}

                                        </td>

                                    </tr>
                                );

                            }.bind(this))}

                            </tbody>
                        </table>
                    </div>
                </div>
            )
        } else {
            return (<div className="card col-lg-7 col-md-6 grid-margin overflow-auto p-3">
                You have not made any withdrawal from your steady growth plan
            </div>);
        }


    }


    withdrawalView() {

        return (

            <div className="mb-3">
                <div className="card">
                    <div className="card-body">
                        <div className="card-title"> Withdrawals</div>
                        <p className="text-info col-sm text-center ">{this.state.accountMessage}</p>
                        <div className="mb-3">
                            <button onClick={this.handleMakeWithdrawal} className="btn btn-primary">Make Withdrawals
                            </button>
                        </div>
                        <div className="row">
                            {this.getYouthWithdrawals()}
                            {this.getSteadyWithdrawals()}


                        </div>
                    </div>
                </div>


                <WithdrawalModal
                    show={this.state.show}
                    handleClose={this.handleClose}
                    onHide={this.handleClose}
                    view={this.state.view}
                    previous={this.previous}
                    nextView={this.nextView}
                    bank={this.state.bank}
                    plans={this.state.plans}
                    handlePlanChange={this.handlePlanChange}
                    handleAmountChange={this.handleAmountChange}
                    handleRequestChange={this.handleRequestChange}
                    plan_id={this.state.plan_id}
                    plan_type={this.state.plan_type}
                    requestType={this.state.requestType}
                    initiateWithdrawal={this.initiateWithdrawal}
                    amount={this.state.amount}
                    accountMessage={this.state.accountMessage}
                    balance={this.state.balance}


                />


            </div>
        );

    }


    handleMakeWithdrawal() {

        this.setState({
            show: true,

        });
    }

    handleClose() {
        this.setState({
            show: false,
        });
    }

    nextView() {

        this.setState({

            view: this.state.view + 1,

        });

    }

    previous() {

        this.setState({

            view: this.state.view - 1,

        });

    }

    handlePlanChange(plan) {

        this.setState({
            plan_id: plan[0],
            plan_type: plan[1]
        });
    }

    handleRequestChange(request) {

        this.setState({
            requestType: request,
        });
    }

    handleAmountChange(amount) {

        this.setState({
            amount: amount,
        });
    }

    initiateWithdrawal() {

        this.setState({
            accountMessage: 'Initiating Withdrawal...Please wait!'
        });

        let form = new FormData();

        form.append('request_type', this.state.requestType);
        form.append('amount', this.state.amount);
        form.append('plan_id', this.state.plan_id);
        form.append('plan_type', this.state.plan_type);

        axios({
            method: 'post',
            url: this.domain.getDomain() + this.domain.initiateTransfer(),
            data: form,
        }).then(function (response) {

            if (response.status == 200) {
                this.setState({
                    accountMessage: response.data.message,
                    balance: response.data.balance,
                });

                if (response.data.success) {

                    this.setState({
                        view: this.state.view + 1,
                    });

                }
            }
        }.bind(this));

    }

    handleVerifyCode() {
        // this.retrievePaystackDetails();

        this.setState({
            accountMessage: 'Saving Account Information ...'
        });

        if (this.state.code == this.state.confirmCode && this.state.confirmCode != 0) {
            let form = new FormData();

            form.append('bank_code', this.state.bank.bank_code);
            form.append('account_number', this.state.bank.account_number);

            axios({
                method: 'post',
                url: this.domain.getDomain() + this.domain.createTransferRecipient(),
                data: form,
            }).then(function (response) {

                if (response.status == 200) {
                    this.setState({
                        accountMessage: response.data.message,
                        user: response.data.user,
                        cards: response.data.cards,
                        bank: response.data.bank,
                        banks: response.data.banks,
                        showCode: !response.data.success,
                    });
                }

            }.bind(this));
        } else {

        }
    }


    render() {

        return (
            <div>
                <nav aria-label="breadcrumb">
                    <ol className="breadcrumb">

                        <li className="breadcrumb-item active" aria-current="page">Withdrawal</li>
                    </ol>
                </nav>

                {this.withdrawalView()}


            </div>
        );

    }
}

export default Withdrawal;