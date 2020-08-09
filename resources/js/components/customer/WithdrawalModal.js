/**
 * Created by MoFoLuWaSo on 9/30/2019.
 */
import React, {Component} from 'react';
//import 'bootstrap/dist/css/bootstrap.min.css';
import Modal from 'react-bootstrap/Modal';
import Button from 'react-bootstrap/Button';

class WithdrawalModal extends Component {

    constructor(props) {
        super(props);

        this.handleClose = this.handleClose.bind(this);
        this.nextView = this.nextView.bind(this);
        this.previous = this.previous.bind(this);
        this.initiateWithdrawal = this.initiateWithdrawal.bind(this);
        this.handlePlanChange = this.handlePlanChange.bind(this);
        this.handleRequestChange = this.handleRequestChange.bind(this);
        this.handleAmountChange = this.handleAmountChange.bind(this);

    }

    handleClose() {
        this.props.handleClose();
    }

    nextView() {
        this.props.nextView();
    }

    previous() {
        this.props.previous();
    }

    initiateWithdrawal(e) {
        e.preventDefault();
        this.props.initiateWithdrawal();
    }

    handlePlanChange(e) {
        let plan = e.target.value.split("_");

        let planType = plan[1];
        let planId = plan[0];


        this.props.handlePlanChange([planId, planType]);
    }

    handleRequestChange(e) {
        let value = e.target.value;

        this.props.handleRequestChange(value);
    }

    handleAmountChange(e) {
        let value = e.target.value;
        this.props.handleAmountChange(value);
    }


    render() {
        switch (this.props.view) {
            case 0:

                return (

                    <Modal
                        show={this.props.show}
                        onHide={this.handleClose}
                        size="md"
                        aria-labelledby="contained-modal-title-vcenter"
                        centered
                    >
                        <Modal.Header closeButton>
                            <Modal.Title id="contained-modal-title-vcenter">
                                Make Withdrawal
                            </Modal.Title>
                        </Modal.Header>
                        <form onSubmit={this.initiateWithdrawal}>
                            <Modal.Body>
                                <p className="text-info">{this.props.accountMessage}</p>
                                <p className="text-info">{this.props.balance}</p>
                                <div className="form-group">

                                    <label>Savings Account</label>
                                    <br/>
                                    <select className="form-control"
                                            required="required"
                                            value={this.props.plan_id+"_"+this.props.plan_type}

                                            onChange={this.handlePlanChange}>
                                        <option></option>
                                        {this.props.plans.map(function (plan) {
                                            return (
                                                <option key={plan.id}
                                                        value={plan.id+"_"+plan.plan_type}>{plan.plan_name} </option>
                                            );
                                        }.bind(this))}

                                    </select>

                                </div>

                                <div className="form-group">

                                    <label>Destination Account</label>
                                    <br/>
                                    <p className="h5">{this.props.bank.account_number} </p>

                                </div>

                                <div className="form-group">

                                    <label>Request Type</label>

                                    <select className="form-control"
                                            required="required"
                                            value={this.props.requestType}
                                            onChange={this.handleRequestChange}>
                                        <option></option>
                                        <option value='0'>Partial</option>
                                        <option value='1'>Full</option>

                                    </select>
                                </div>
                                <div className="form-group">

                                    <label>Amount</label>
                                    <br/>

                                    <input type="number" defaultValue={this.props.amount} min='1'
                                           onChange={this.handleAmountChange} required="required"
                                           className="form-control"/>
                                </div>


                            </Modal.Body>
                            <Modal.Footer>
                                <div className="row">
                                    <div className="col-md-3 mb-3">
                                        <Button className="btn-outline-primary"
                                                onClick={this.handleClose}>Cancel</Button>
                                    </div>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                                    <div className="col-md-3 mb-3">
                                        <button className='btn btn-primary' type='submit'>Continue</button>
                                    </div>
                                </div>
                            </Modal.Footer>
                        </form>
                    </Modal>
                );

            case 1:

                return (
                    <div className="m-auto col-lg-6 col-md-6">
                        <div><h3 className="text-center">Success</h3></div>
                        <div className="card text-center ">
                            <div className="card-body">
                                <div className="card-title"></div>
                                <i className="text-success fa fa-5x fa-check "></i>
                                Withdrawal Initiated Successfully
                                <small>All withdrawals will be processed within 24hours.</small>
                            </div>
                            <div className="col-md-3 mb-3">
                                <button className='btn btn-primary' type='button' onClick={this.handleClose}>Close
                                </button>
                            </div>
                        </div>
                    </div>
                );
        }

    }


}

export default WithdrawalModal;