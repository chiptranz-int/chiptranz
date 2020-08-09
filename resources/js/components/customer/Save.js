/**
 * Created by MoFoLuWaSo on 9/21/2019.
 */
import React, {Component} from 'react';
import Domain from '../scalfolding/Domain';
import ChipLoader from '../ChipLoader';
import PlanHelper from './savings/PlanHelper';

class Save extends Component {

    constructor(props) {

        super(props);

        this.state = {
            user: {},
            plans: [],
            show: false,
            view: 0,
            amount: 500,
            transact_id: '',
            plan_id: '',
            plan_type: '',
            cards: [],
            message: '',
        };


        this.domain = new Domain();
        this.helper = new PlanHelper();
        this.handle = "";

        this.retrieveUserPlans = this.retrieveUserPlans.bind(this);
        this.getView = this.getView.bind(this);
        this.handleSaveChange = this.handleSaveChange.bind(this);
        this.handleCardPage = this.handleCardPage.bind(this);
        this.handleBack = this.handleBack.bind(this);
        this.getBackButton = this.getBackButton.bind(this);
        this.handleSubmit = this.handleSubmit.bind(this);
        this.successView = this.successView.bind(this);
    }

    componentDidMount() {
        this.retrieveUserPlans();
    }


    handleSaveChange(e) {
        let property = e.target.getAttribute("itemid");
        let value = e.target.value;

        if (property == 'plan_id') {

            let plan = e.target.value.split("_");

            let planType = plan[1];
             value = plan[0];

            this.setState({
                plan_type: planType,
            })
        }

        this.setState({
            [property]: value
        })
    }


    retrieveUserPlans() {

        axios.get(this.domain.getDomain() + this.domain.getPlans()).then(function (response) {


            if (response.status == 200) {

                this.setState({
                    user: response.data.user,
                    plans: response.data.plans,
                    cards: response.data.cards,

                });

            }


        }.bind(this));

    }

    getView() {
        switch (this.state.view) {
            case 0:
                clearInterval(this.handle);
                return (this.getMainSaveView());
            case 1:
                return (this.getCardView());
            case 2:
                return (this.successView());
            default:
                return (<ChipLoader/>);


        }
    }

    handleBack() {
        let page = this.state.view;
        this.setState({
            view: (page - 1),
        });
    }

    getBackButton() {
        if (this.state.view != 0 && this.state.view != 2) {
            return (<button onClick={this.handleBack}
                            className="float-right btn btn-sm btn-outline-primary">Back </button>);
        }
    }

    handleCardPage(e) {
        e.preventDefault();
        this.setState({
            view: 1,
        });
    }

    handleSubmit(e) {
        e.preventDefault();


        let form = new FormData();
        form.append('plan_id', this.state.plan_id);
        form.append('amounts', this.state.amount);
        form.append('transact_id', this.state.transact_id);
        form.append('plan_type', this.state.plan_type);

        this.setState({
            message: 'Please wait! Processing savings'
        });
        axios({
            method: 'post',
            url: this.domain.getDomain() + this.domain.saveNow(),
            data: form,
        }).then(function (response) {
            if (response.data.success) {
                this.setState({
                    view: 2,

                });
                this.handle = setInterval(function () {
                    this.setState({
                        view: 0
                    })
                }.bind(this), 4000)
            } else {
                this.setState({
                    message: 'Error! Transaction failed. Ensure you have money in your account and try again'
                });

            }

        }.bind(this));

    }

    successView() {
        return (
            <div className="m-auto col-lg-6 col-md-6">
                <div><h3 className="text-center">Success</h3></div>
                <div className="card text-center ">
                    <div className="card-body">
                        <div className="card-title"></div>
                        <i className="text-success fa fa-5x fa-check "></i>
                        Payment Successful
                        <small>redirecting in 3 seconds...</small>
                    </div>
                </div>
            </div>
        );
    }


    getMainSaveView() {
        if (this.state.plans[0] != null) {


            return (
                <div className="m-auto col-lg-6 col-md-6">
                    <div><h3 className="text-center">One-Time Savings</h3></div>
                    <div className="card  ">
                        <div className="card-body">
                            <div className="card-title"></div>
                            <form onSubmit={this.handleCardPage}>


                                <div className="form-group col-12">
                                    <label className="col-form-label">Amount (&#x20A6;) </label>
                                    <br/>
                                    <input value={this.state.amount} itemID="amount" required='required'
                                           onChange={this.handleSaveChange}
                                           className="form-control"/>

                                </div>

                                <br/>

                                <div className="form-group col-12">
                                    <label className="col-form-label">Select a Plan to save into </label>
                                    <br/>
                                    <select className="form-control" itemID="plan_id" required='required'


                                            onChange={this.handleSaveChange}>
                                        <option></option>
                                        {this.state.plans.map(function (plan) {
                                            return (
                                                <option key={plan.id} itemID={plan.plan_type}
                                                        value={plan.id+"_"+plan.plan_type}>{plan.plan_name} </option>
                                            );
                                        }.bind(this))}

                                    </select>

                                </div>


                                <div className="text-center mt-4">
                                    <button type="submit" className=" btn btn-primary mb-2">Next</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            )
                ;

        }
    }

    getCardView() {
        return (
            <div className="m-auto col-lg-6 col-md-6">
                <div><h3 className="text-center">One-Time Savings</h3>
                    <p className='text-info'>    {this.state.message}</p>
                </div>
                <div className="card  ">
                    <div className="card-body">
                        <div className="card-title"></div>
                        <form onSubmit={this.handleSubmit}>


                            <div className="form-group col-12">
                                <label className="col-form-label">Select a Card for Payment </label>
                                <br/>
                                <select className="form-control" itemID="transact_id" required='required'


                                        onChange={this.handleSaveChange}>
                                    <option></option>
                                    {this.state.cards.map(function (card) {
                                        return (
                                            <option key={card.id}
                                                    value={card.id}>{this.helper.filterCard(card)}</option>
                                        );
                                    }.bind(this))}

                                </select>

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


    render() {


        return (


            <div className="">
                <nav aria-label="breadcrumb">
                    <ol className="breadcrumb">
                        <li className="breadcrumb-item active"><a href="#">Save Now</a></li>

                    </ol>
                </nav>
                {this.getBackButton()}
                {this.getView()}
            </div>


        );
    }
}

export default Save;