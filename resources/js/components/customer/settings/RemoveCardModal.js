/**
 * Created by MoFoLuWaSo on 9/30/2019.
 */
import React, {Component} from 'react';
//import 'bootstrap/dist/css/bootstrap.min.css';
import Modal from 'react-bootstrap/Modal';
import Button from 'react-bootstrap/Button';

class RemoveCardModal extends Component {

    constructor(props) {
        super(props);

        this.handleCloseRemove = this.handleCloseRemove.bind(this);
        this.removeCard = this.removeCard.bind(this);


    }

    handleCloseRemove() {
        this.props.handleCloseRemove();
    }

    removeCard() {
          this.props.removeCard();
    }


    render() {

        return (

            <Modal
                show={this.props.show}
                onHide={this.handleCloseRemove}
                size="lg"
                aria-labelledby="contained-modal-title-vcenter"
                centered
            >
                <Modal.Header closeButton>
                    <Modal.Title id="contained-modal-title-vcenter">
                        Remove Card
                    </Modal.Title>
                </Modal.Header>
                <Modal.Body>
                    <div className="text-center ">
                        <div>
                            <p className="h4">All plans on this card will be automatically moved to your last added card</p>
                        </div>
                        <br/>
                        <div>
                            <p className="h5">Are you sure you want to remove card?</p>
                        </div>
                    </div>
                </Modal.Body>
                <Modal.Footer>
                    <div className="row">
                        <div className="col-md-3 ml-5">
                            <Button className="btn-outline-primary" onClick={this.handleCloseRemove}>Cancel</Button>
                        </div>
                        <div className="col-md-3 ml-3">
                            <Button onClick={this.removeCard}>Remove</Button>
                        </div>
                    </div>
                </Modal.Footer>
            </Modal>
        );


    }


}

export default RemoveCardModal;