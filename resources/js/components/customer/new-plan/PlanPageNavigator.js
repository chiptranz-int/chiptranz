/**
 * Created by MoFoLuWaSo on 9/22/2019.
 */
import React, {Component} from 'react';
import PlanHelper from '../savings/PlanHelper';

class PlanPageNavigator extends Component {

    constructor(props) {
        super(props);

        this.planComponent = this.planComponent.bind(this);
        this.planName = this.planName.bind(this);
        this.frequencyPage = this.frequencyPage.bind(this);
        this.amountPage = this.amountPage.bind(this);
        this.durationPage = this.durationPage.bind(this);
        this.cardPage = this.cardPage.bind(this);

        this.handlePlanNameChange = this.handlePlanNameChange.bind(this);
        this.handlePlanNameSubmit = this.handlePlanNameSubmit.bind(this);

        this.handleFrequencyChange = this.handleFrequencyChange.bind(this);
        this.handleFrequencySubmit = this.handleFrequencySubmit.bind(this);

        this.handleAmountChange = this.handleAmountChange.bind(this);
        this.handleAmountSubmit = this.handleAmountSubmit.bind(this);


        this.getTodaysDate = this.getTodaysDate.bind(this);
        this.getNextThrityDays = this.getNextThrityDays.bind(this);
        this.updateNextThirtyDay = this.updateNextThirtyDay.bind(this);

        this.handleDurationFromChange = this.handleDurationFromChange.bind(this);
        this.handleDurationToChange = this.handleDurationToChange.bind(this);
        this.handleDurationSubmit = this.handleDurationSubmit.bind(this);

        this.handleCardChange = this.handleCardChange.bind(this);
        this.handleCardSubmit = this.handleCardSubmit.bind(this);
        this.handleAddNewCard = this.handleAddNewCard.bind(this);


        this.today = "";
        this.thirty = "";

        this.frequency = [
            {'id': 1, 'value': 'Daily'},
            {'id': 2, 'value': 'Weekly'},
            {'id': 3, 'value': 'Monthly'},
        ];

        this.helper = new PlanHelper();

    }

    componentDidMount() {
        this.today = this.getTodaysDate();
        this.thirty = this.getNextThrityDays();
    }

    getTodaysDate() {
        let theDate = new Date();
        let year = theDate.getFullYear();
        let month = this.getFullDay(theDate.getMonth() + 1);
        let day = this.getFullDay(theDate.getDate());

        return year + "-" + month + "-" + day;
    }

    getNextThrityDays() {
        let theDate = new Date();
        let newDate = new Date(theDate.getFullYear(), theDate.getMonth(), (parseInt(theDate.getDate()) + 90));
        let year = newDate.getFullYear();
        let month = this.getFullDay(newDate.getMonth() + 1);
        let day = this.getFullDay(newDate.getDate());
        return year + "-" + month + "-" + day;
    }

    getFullDay(value) {

        if (value < 10) {
            return "0" + value;
        } else {
            return value;
        }
    }

    updateNextThirtyDay(from,value) {

        let date = from.split("-");
        let newDate = new Date(date[0], parseInt(date[1]) - 1, (parseInt(date[2]) + value));
        let year = newDate.getFullYear();
        let month = this.getFullDay(newDate.getMonth() + 1);
        let day = this.getFullDay(newDate.getDate());
        this.thirty = year + "-" + month + "-" + day;


    }


    planComponent() {

        switch (this.props.page) {

            case 1:
                return this.planName();

            case 2:
                return this.frequencyPage();

            case 3:
                return this.amountPage();

            case 4:
                return this.durationPage();

            case 5:
                return this.cardPage();

            default:
                return (
                    <div><h3>Loading</h3></div>
                );
        }

    }

    /**************************
     * Plan Name  Section     *
     *************************/



    handlePlanNameChange(evt) {
        this.props.handlePlanNameChange(evt.target.value);


    }

    handlePlanNameSubmit(evt) {
        evt.preventDefault();
        this.props.handlePlanNameSubmit();


    }


    planName() {

        return (

            <div>
                <form onSubmit={this.handlePlanNameSubmit}>
                    <div className="list d-flex align-items-center pb-3">

                        <div className="wrapper w-100 ml-3">


                        </div>
                    </div>

                    <div className="list d-flex align-items-center border-bottom pb-3">

                        <div className="wrapper w-100 ml-3">

                            <div className="form-group">
                                <label htmlFor="plan-name" className="font-weight-bold">Plan Name</label>
                                <input id="plan-name" required="required" className="form-control"
                                       placeholder="e.g. School Fees" value={this.props.planName}
                                       onChange={this.handlePlanNameChange}/>
                            </div>


                        </div>
                    </div>

                    <div className="list d-flex align-items-center pb-3">

                        <div className="wrapper w-100 ml-3">


                        </div>
                    </div>


                    <div className="list text-center d-flex align-items-center border-bottom py-3">

                        <div className="wrapper w-100 ml-3">
                            <div className="text-right">
                                <button type="submit" className="btn btn-primary">Next <i
                                    className="fa fa-arrow-right"></i></button>
                            </div>

                        </div>
                    </div>


                </form>


            </div>

        );

    }


    /******************************
     * Savings Frequency Section  *
     ******************************/

    handleFrequencyChange(evt) {

        this.props.handleFrequencyChange(evt.target.value);

    }

    handleFrequencySubmit(evt) {

        evt.preventDefault();

        this.props.handleFrequencySubmit();

    }

    frequencyPage() {

        return (

            <div>
                <form onSubmit={this.handleFrequencySubmit}>
                    <div className="list d-flex align-items-center pb-3">

                        <div className="wrapper w-100 ml-3">


                        </div>
                    </div>

                    <div className="list d-flex align-items-center border-bottom pb-3">

                        <div className="wrapper w-100 ml-3">

                            <div className="form-group">
                                <label htmlFor="save-frequency" className="font-weight-bold">Frequency</label>

                                <select id="save-frequency" required="required" className="form-control"
                                        value={this.props.saveFrequency}
                                        onChange={this.handleFrequencyChange}>
                                    <option value=''>Select Frequency</option>
                                    {this.frequency.map(function (theFrequency) {
                                        return (<option key={theFrequency.id}
                                                        value={theFrequency.id}>{theFrequency.value}</option>);
                                    })}
                                </select>

                            </div>


                        </div>
                    </div>

                    <div className="list d-flex align-items-center pb-3">

                        <div className="wrapper w-100 ml-3">


                        </div>
                    </div>


                    <div className="list text-center d-flex align-items-center border-bottom py-3">

                        <div className="wrapper w-100 ml-3">
                            <div className="text-right">
                                <button type="submit" className="btn btn-primary">Next <i
                                    className="fa fa-arrow-right"></i></button>
                            </div>

                        </div>
                    </div>


                </form>


            </div>

        );


    }


    /******************************
     * Savings Amount Section     *
     ******************************/

    handleAmountChange(evt) {
        this.props.handleAmountChange(evt.target.value);
    }

    handleAmountSubmit(evt) {

        evt.preventDefault();
        this.props.handleAmountSubmit();

    }

    amountPage() {
        return (

            <div>
                <form onSubmit={this.handleAmountSubmit}>
                    <div className="list d-flex align-items-center pb-3">

                        <div className="wrapper w-100 ml-3">


                        </div>
                    </div>

                    <div className="list d-flex align-items-center border-bottom pb-3">

                        <div className="wrapper w-100 ml-3">

                            <div className="form-group">
                                <label htmlFor="save-amount" className="font-weight-bold">Amount</label>

                                <input id="save-amount" type="number" required="required"
                                       className="form-control" min='100' value={this.props.saveAmount}
                                       placeholder="&#x20A6;" onChange={this.handleAmountChange}/>


                            </div>


                        </div>
                    </div>

                    <div className="list d-flex align-items-center pb-3">

                        <div className="wrapper w-100 ml-3">


                        </div>
                    </div>


                    <div className="list text-center d-flex align-items-center border-bottom py-3">

                        <div className="wrapper w-100 ml-3">
                            <div className="text-right">
                                <button type="submit" className="btn btn-primary">Next <i
                                    className="fa fa-arrow-right"></i></button>
                            </div>

                        </div>
                    </div>


                </form>


            </div>

        );
    }


    /******************************
     * Savings Duration Section     *
     ******************************/

    handleDurationFromChange(evt) {
        this.props.handleDurationFromChange(evt.target.value);

        this.updateNextThirtyDay(evt.target.value,parseInt(this.props.extend));
    }

    handleDurationToChange(evt) {

        this.props.handleDurationToChange(evt.target.value);

    }

    handleDurationSubmit(evt) {
        evt.preventDefault();
        this.props.handleDurationSubmit();

    }

    durationPage() {

        return (

            <div>
                <form onSubmit={this.handleDurationSubmit}>
                    <div className="list d-flex align-items-center pb-3">

                        <div className="wrapper w-100 ml-3">


                        </div>
                    </div>

                    <div className="list d-flex align-items-center border-bottom pb-3">

                        <div className="wrapper w-100 ml-3">

                            <div className="form-group">
                                <label className="col-sm-4 font-weight-bold" htmlFor="start">Start Date</label>
                                <div className="col-sm-8">
                                    <input type="date" className="form-control" id="start"
                                           value={this.props.durationFrom} min={this.today}
                                           required="required" onChange={this.handleDurationFromChange}/>
                                </div>
                            </div>


                        </div>
                    </div>

                    <div className="list d-flex align-items-center pb-3">

                        <div className="wrapper w-100 ml-3">
                            <div className="form-group">
                                <label className="col-sm-4 font-weight-bold" htmlFor="withdrawal">Withdrawal
                                    Date</label>
                                <div className="col-sm-8">
                                    <input type="date" className="form-control" id="withdrawal"
                                           value={this.props.durationTo} min={this.thirty}
                                           required="required" onChange={this.handleDurationToChange}/>
                                </div>
                            </div>

                        </div>
                    </div>


                    <div className="list text-center d-flex align-items-center border-bottom py-3">

                        <div className="wrapper w-100 ml-3">
                            <div className="text-right">
                                <button type="submit" className="btn btn-primary">Link Card
                                    <i className="fa fa-credit-card"></i>
                                </button>
                            </div>

                        </div>
                    </div>


                </form>


            </div>

        );
    }


    /******************************
     * Card Section                *
     ******************************/
    handleCardChange(evt) {
        this.props.handleCardChange(evt.target.value);
    }

    handleCardSubmit(evt) {
        evt.preventDefault();
        this.props.handleCardSubmit();

    }

    handleAddNewCard() {
        this.props.handleAddNewCard();
    }

    cardPage() {

        return (

            <div>
                <form onSubmit={this.handleCardSubmit}>
                    <div className="list d-flex align-items-center pb-3">

                        <div className="wrapper w-100 ml-3">


                        </div>
                    </div>

                    <div className="list d-flex align-items-center border-bottom pb-3">

                        <div className="wrapper w-100 ml-3">

                            <div className="form-group">
                                <label className="col-sm-12 font-weight-bold" htmlFor="start">Select a card for plan</label>
                                <div className="col-sm-12">
                                    <select className="form-control" itemID="transact_id"


                                            onChange={this.handleCardChange}>
                                        <option></option>
                                        {this.props.cards.map(function (card) {
                                            return (
                                                <option key={card.id}
                                                        value={card.id}>{this.helper.filterCard(card)} </option>
                                            );
                                        }.bind(this))}

                                    </select>
                                </div>
                            </div>


                        </div>
                    </div>




                    <div className="list text-center d-flex align-items-center border-bottom py-3">

                        <div className="wrapper w-100 ml-3">
                            <div className="text-right">
                                <button type="submit" className="btn btn-primary">Select Card
                                    <i className="fa fa-credit-card"></i>
                                </button>
                            </div>

                        </div>


                    </div>


                </form>


            </div>

        );

    }


    render() {


        return (

            <div className="content-wrapper ">

                <div className="container">
                    <div className="row">
                        <div className="card container col-lg-12 col-md-12 grid-margin ">

                            <div className="card text-dark  card-shadow-primary">

                                <div className="card-body">
                                    <div className="float-right"><a >
                                        <button onClick={this.props.handlePreviousPage}
                                                className="btn btn-sm btn-outline-info">Back
                                        </button>
                                    </a></div>
                                    <div className="brand-logo">
                                        <img src={`../chiptranz-vendors/images/logo.svg `} alt="logo"
                                             style={this.props.titleStyle}/>
                                    </div>

                                    <br />

                                    <h2>{this.props.name}</h2>
                                    <p className="h4 font-weight-normal">{this.props.caption}</p>


                                </div>

                            </div>
                        </div>


                    </div>
                    <div className="row">
                        <div className="col-lg-2"></div>
                        <div className="col-lg-8 grid-margin stretch-card">
                            <div className="card">
                                <div className="card-body">
                                    <div className="d-flex justify-content-between">
                                        <h3 className="card-title">
                                            <i className="fa fa-users text-primary fa-2x"></i> {this.props.name}</h3>
                                    </div>
                                    {this.planComponent()}

                                </div>
                            </div>
                        </div>


                    </div>
                </div>


            </div>






        );
    }


}

export default PlanPageNavigator;