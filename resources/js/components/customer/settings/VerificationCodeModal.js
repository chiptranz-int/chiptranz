/**
 * Created by MoFoLuWaSo on 9/30/2019.
 */
import React, {Component} from 'react';
//import 'bootstrap/dist/css/bootstrap.min.css';
import Modal from 'react-bootstrap/Modal';
import Button from 'react-bootstrap/Button';

class VerificationCodeModal extends Component {

    constructor(props) {
        super(props);

        this.handleCloseCode = this.handleCloseCode.bind(this);

        this.handleResendCode = this.handleResendCode.bind(this);
        this.handleCodeChange = this.handleCodeChange.bind(this);
        this.handleVerifyCode = this.handleVerifyCode.bind(this);


    }

    handleCloseCode() {
        this.props.handleCloseCode();
    }


    handleResendCode(e) {
        e.preventDefault();
        this.props.handleResendCode();
    }

    handleCodeChange(e) {
        this.props.handleCodeChange(e.target.value);
    }

    handleVerifyCode(e) {
        e.preventDefault();
        this.props.handleVerifyCode();
    }


    render() {

        return (

            <Modal
                show={this.props.showCode}
                onHide={this.handleCloseCode}
                size="md"
                aria-labelledby="contained-modal-title-vcenter"
                centered
            >
                <Modal.Header closeButton>
                    <Modal.Title id="contained-modal-title-vcenter">
                        Confirm Verification Code
                    </Modal.Title>
                </Modal.Header>
                <form onSubmit={this.handleVerifyCode}>
                <Modal.Body>
                    <div className="text-center ">
                        <div>
                            <p className="h4">A confirmation code has been sent to your mobile number, please enter it to continue</p>
                          <br />  <p className="h6 text-info">{this.props.accountMessage}</p>
                        </div>
                    </div>
<br/>
<br/>

                        <div className="form-group">

                            <label>Confirmation Code</label>

                            <input type="text" defaultValue={this.props.confirmCode}
                                   onChange={this.handleCodeChange} required="required"
                                   className="form-control"/>
                        </div>


                        <div className="form-group">


<button type='button' onClick={this.handleResendCode} className='btn btn-sm btn-info'> Re-Send Code</button>

                        </div>


                </Modal.Body>
                <Modal.Footer>
                    <div className="row">
                        <div className="col-md-3 mb-3">
                            <Button className="btn-outline-primary" onClick={this.handleCloseCode}>Cancel</Button>
                        </div>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                        <div className="col-md-3 mb-3">
                            <button className='btn btn-primary' type='submit'>Verify</button>
                        </div>
                    </div>
                </Modal.Footer>
            </form>
            </Modal>
        );


    }


}

export default VerificationCodeModal;