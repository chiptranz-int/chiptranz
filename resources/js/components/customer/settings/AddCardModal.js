/**
 * Created by MoFoLuWaSo on 9/30/2019.
 */
import React, {Component} from 'react';
//import 'bootstrap/dist/css/bootstrap.min.css';
import Modal from 'react-bootstrap/Modal';
import Button from 'react-bootstrap/Button';

class AddCardModal extends Component {

    constructor(props) {
        super(props);

        this.handleCloseAdd = this.handleCloseAdd.bind(this);
        this.addCard = this.addCard.bind(this);


    }

    handleCloseAdd() {
        this.props.handleCloseAdd();
    }

    addCard() {
        this.props.addCard();
    }


    render() {

        return (

            <Modal
                show={this.props.showAdd}
                onHide={this.handleCloseAdd}
                size="lg"
                aria-labelledby="contained-modal-title-vcenter"
                centered
            >
                <Modal.Header closeButton>
                    <Modal.Title id="contained-modal-title-vcenter">
                        Add Card
                    </Modal.Title>
                </Modal.Header>
                <Modal.Body>
                    <div className="text-center ">
                        <div>
                            <p className="h4">&#x20A6; 100 will be charged from your account and saved into your recent
                                savings plan</p>
                        </div>
                        <br/>
                        <div>
                            <p className="h5">Continue?</p>
                        </div>
                    </div>
                </Modal.Body>
                <Modal.Footer>
                    <div className="row">
                        <div className="col-md-3 mb-3">
                            <Button className="btn-outline-primary" onClick={this.handleCloseAdd}>Cancel</Button>
                        </div>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                        <div className="col-md-3 mb-3">
                            <Button onClick={this.addCard}>Continue</Button>
                        </div>
                    </div>
                </Modal.Footer>
            </Modal>
        );


    }


}

export default AddCardModal;