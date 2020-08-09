/**
 * Created by MoFoLuWaSo on 9/30/2019.
 */
import React, {Component} from 'react';
//import 'bootstrap/dist/css/bootstrap.min.css';
import Modal from 'react-bootstrap/Modal';
import Button from 'react-bootstrap/Button';

class AddBankModal extends Component {

    constructor(props) {
        super(props);

        this.handleCloseAddBank = this.handleCloseAddBank.bind(this);
        this.handleAccountNumber = this.handleAccountNumber.bind(this);
        this.addBank = this.addBank.bind(this);
        this.handleBankChange = this.handleBankChange.bind(this);


    }

    handleCloseAddBank() {
        this.props.handleCloseAddBank();
    }

    addBank(e) {
        e.preventDefault();
        this.props.addBank();
    }

    handleAccountNumber(e) {

        let value = e.target.value;

        this.props.handleAccountNumber(value);
    }

    handleBankChange(e) {
        let value = e.target.value;
        this.props.handleBankChange(value);
    }


    render() {

        return (

            <Modal
                show={this.props.showAddBank}
                onHide={this.handleCloseAddBank}
                size="md"
                aria-labelledby="contained-modal-title-vcenter"
                centered
            >
                <Modal.Header closeButton>
                    <Modal.Title id="contained-modal-title-vcenter">
                        Add Bank Account Information
                    </Modal.Title>
                </Modal.Header>
                <form onSubmit={this.addBank}>
                    <Modal.Body>

                        <div className="form-group">

                            <label>Enter Account Number</label>
                            <br/>
                            <span className="text-muted"><small>Please note that all withdrawals will be paid into this account</small></span>
                            <input type="text" defaultValue={this.props.bank.account_number}
                                   onChange={this.handleAccountNumber} required="required"
                                   className="form-control"/>
                        </div>

                        <div className="form-group">

                            <label>Select Bank</label>

                            <select className="form-control" itemID="bank_code"
                                    required="required"
                                    value={this.props.bank.bank_code}
                                    onChange={this.handleBankChange}>
                                <option></option>
                                {this.props.banks.map(function (bank) {
                                    return (
                                        <option key={bank.id}
                                                value={bank.code}>{bank.name} </option>
                                    );
                                }.bind(this))}

                            </select>
                        </div>

                    </Modal.Body>
                    <Modal.Footer>
                        <div className="row">
                            <div className="col-md-3 mb-3">
                                <Button className="btn-outline-primary"
                                        onClick={this.handleCloseAddBank}>Cancel</Button>
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


    }


}

export default AddBankModal;