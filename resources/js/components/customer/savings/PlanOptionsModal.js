/**
 * Created by MoFoLuWaSo on 9/30/2019.
 */
import React, {Component} from 'react';
//import 'bootstrap/dist/css/bootstrap.min.css';
import Modal from 'react-bootstrap/Modal';
import Button from 'react-bootstrap/Button';
class PlanOptionsModal extends Component {

    constructor(props) {
        super(props);

        this.handleClose = this.handleClose.bind(this);
        this.handleOverview = this.handleOverview.bind(this);
        this.handlePlanSettings = this.handlePlanSettings.bind(this);

    }

    handleClose(){
        this.props.handleClose();
    }

    handleOverview(){
        this.props.handleOverview();
    }

    handlePlanSettings(){
        this.props.handlePlanSettings();
    }



    render() {

        return (

        <Modal
            show={this.props.show}
            onHide={this.handleClose}
            size="sm"
            aria-labelledby="contained-modal-title-vcenter"
            centered
        >
            <Modal.Header closeButton>
                <Modal.Title id="contained-modal-title-vcenter">
                    Plan Options
                </Modal.Title>
            </Modal.Header>
            <Modal.Body>
                <div className="text-center ">
                <div>
                    <button className="btn btn-lg btn-outline-info" onClick={this.handleOverview}>Overview</button>
                </div>
                <br />
                <div>
                    <button className="btn btn-lg btn-outline-info" onClick={this.handlePlanSettings}>Plan Settings</button>
                </div>
                </div>
            </Modal.Body>
            <Modal.Footer>
                <Button onClick={this.handleClose}>Close</Button>
            </Modal.Footer>
        </Modal>
        );


    }


}

export default PlanOptionsModal;