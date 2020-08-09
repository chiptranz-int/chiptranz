/**
 * Created by MoFoLuWaSo on 9/21/2019.
 */

import React, {Component} from 'react';
import Domain from '../scalfolding/Domain.js';
import PlanOptions from '../first-customer/PlanOptions';
import PlanPageNavigation from './PlanPageNavigator';
import axios from 'axios';


class YouthOption extends Component {

    constructor(props) {
        super(props);

        this.state = {
            page: 1,
            planType: 0,
            planName: '',
            saveFrequency: 0,
            saveAmount: '',
            durationFrom: '',
            durationTo: '',
            existCard: '',
            cards: [],
            paystack: [],
            user: {},
        };

        this.domain = new Domain();


        this.titleStyle = {
            width: 150,
        };


        this.handlePlanNavigation = this.handlePlanNavigation.bind(this);
        this.handlePreviousPage = this.handlePreviousPage.bind(this);

        this.handlePlanNameChange = this.handlePlanNameChange.bind(this);
        this.handlePlanNameSubmit = this.handlePlanNameSubmit.bind(this);

        this.handleFrequencyChange = this.handleFrequencyChange.bind(this);
        this.handleFrequencySubmit = this.handleFrequencySubmit.bind(this);

        this.handleAmountChange = this.handleAmountChange.bind(this);
        this.handleAmountSubmit = this.handleAmountSubmit.bind(this);

        this.handleDurationFromChange = this.handleDurationFromChange.bind(this);
        this.handleDurationToChange = this.handleDurationToChange.bind(this);
        this.handleDurationSubmit = this.handleDurationSubmit.bind(this);

        this.retrievePaystackDetails = this.retrievePaystackDetails.bind(this);
        this.handlePaySubmit = this.handlePaySubmit.bind(this);


    }


    componentDidMount() {

        if (this.props.user) {
            this.setState({
                user: this.props.user,
            })
        }
    }


    handlePlanNavigation(type) {
        this.setState({
            page: this.state.page + 1,
            planType: type,
        });
    }

    handlePreviousPage() {

        if (this.state.page >= 0) {

            this.setState({
                page: this.state.page - 1,
            });
        }


    }


    /**************************
     * Plan Name  Section     *
     *************************/

    handlePlanNameChange(value) {
        this.setState({
            planName: value,
        });


    }

    handlePlanNameSubmit() {

        this.setState({
            page: this.state.page + 1,

        });

    }


    /******************************
     * Savings Frequency Section  *
     ******************************/

    handleFrequencyChange(value) {
        this.setState({
            saveFrequency: value,
        });
    }

    handleFrequencySubmit() {

        this.setState({
            page: this.state.page + 1,

        });

    }


    /******************************
     * Savings Amount Section     *
     ******************************/

    handleAmountChange(value) {
        this.setState({
            saveAmount: value,
        });
    }

    handleAmountSubmit() {

        this.setState({
            page: this.state.page + 1,

        });
        this.retrievePaystackDetails();


    }

    /******************************
     * Savings Duration Section     *
     ******************************/

    handleDurationFromChange(value) {
        this.setState({
            durationFrom: value,
        });

    }

    handleDurationToChange(value) {
        this.setState({
            durationTo: value,
        });
    }

    handleDurationSubmit(response) {

        if (this.retrievePaystackDetails()) {
            this.handlePaySubmit();
        }


        /*this.setState({
         page: this.state.page + 1,

         });*/

        //add card here
        //First go to backend to get paystack information


    }

    retrievePaystackDetails() {
        axios.get(this.domain.getDomain() + this.domain.paystackDetailUrl()).then(function (response) {
            if (response.status == 200) {


                this.setState({
                    paystack: response.data,
                });


            }
        }.bind(this));
        try {
            if (this.state.paystack.reference.length > 0) {

                return true;
            }
        } catch (e) {

        }

    }


    /******************************
     * Card Information Section     *
     ******************************/

    handlePaySubmit() {


        let handler = PaystackPop.setup({
            key: this.state.paystack.pKey,
            email: this.state.paystack.email,
            amount: 10000,
            currency: "NGN",
            firstname: this.state.paystack.first_name,
            lastname: this.state.paystack.last_name,
            ref: this.state.paystack.reference, // generates a pseudo-unique reference. Please replace with a reference you generated. Or remove the line entirely so our API will generate one for you
            metadata: {
                custom_fields: [
                    {
                        display_name: "ChipTranz",
                        variable_name: "mobile_number",
                        value: "+2349012697371"
                    }
                ]
            },
            callback: function (response) {


                axios.get(this.domain.getDomain() + this.domain.paystackUrl() + '/' + response.reference).then(
                    function (resp) {


                            let form = new FormData();
                            form.append('plan_name', this.state.planName);
                            form.append('frequency', this.state.saveFrequency);
                            form.append('amounts', this.state.saveAmount);
                            form.append('start_date', this.state.durationFrom);
                            form.append('withdrawal_date', this.state.durationTo);
                            form.append('plan_type', this.state.planType);
                            form.append('transact_id', resp.data.transaction_id);
                            form.append('reference', resp.data.reference);
                            form.append('amount', 100);

                            axios({
                                method: 'post',
                                url: this.domain.getDomain() + this.domain.planSetupUrl(),
                                data: form,
                            }).then(function (response) {
                                if (response.data.success) {

                                    window.location = this.domain.getDomain()+this.domain.getHome();
                                    //after saving to database the other information
                                    /*this.setState({
                                     page: oldPage + 1,
                                     cards: Object.entries(response.data.data),
                                     paystack: response.data.paystack,

                                     });
                                     */

                                }

                            }.bind(this));



                    }.bind(this)
                );
            }.bind(this),
            onClose: function () {
//                    alert('window closed');
                //here go to the db and remove any account that does not have card registered
            }
        });
        handler.openIframe();

    }

    render() {
        let name = "Youth Goals";
        switch (this.state.page) {

            case 0:
                return ( <PlanOptions user={this.state.user}/>);

            case 1:


                return (
                    <PlanPageNavigation
                        name={name}
                        caption="Enter a name for your youth goal account"
                        titleStyle={this.titleStyle}
                        handlePreviousPage={this.handlePreviousPage}
                        page={this.state.page}

                        handlePlanNameSubmit={this.handlePlanNameSubmit}
                        planName={this.state.planName}
                        handlePlanNameChange={this.handlePlanNameChange}
                    />

                );
            case 2:


                return (
                    <PlanPageNavigation
                        name={name}
                        caption="How often would you like to save into this account?"
                        titleStyle={this.titleStyle}
                        handlePreviousPage={this.handlePreviousPage}
                        page={this.state.page}

                        handleFrequencySubmit={this.handleFrequencySubmit}
                        saveFrequency={this.state.saveFrequency}
                        handleFrequencyChange={this.handleFrequencyChange}
                    />

                );

            case 3:


                return (
                    <PlanPageNavigation
                        name={name}
                        caption="How much would you like to save into this account periodically ?"
                        titleStyle={this.titleStyle}
                        handlePreviousPage={this.handlePreviousPage}
                        page={this.state.page}

                        handleAmountSubmit={this.handleAmountSubmit}
                        saveAmount={this.state.saveAmount}
                        handleAmountChange={this.handleAmountChange}
                    />

                );

            case 4:


                return (
                    <PlanPageNavigation
                        name={name}
                        caption="select a start and a withdrawal date for your
                                    savings plan"
                        titleStyle={this.titleStyle}
                        handlePreviousPage={this.handlePreviousPage}
                        page={this.state.page}

                        handleDurationSubmit={this.handleDurationSubmit}
                        durationFrom={this.state.durationFrom}
                        handleDurationFromChange={this.handleDurationFromChange}

                        paystack={this.state.paystack}
                        durationTo={this.state.durationTo}
                        handleDurationToChange={this.handleDurationToChange}
                    />

                );

            case 5:


                return (
                    <PlanPageNavigation
                        name={name}
                        caption="select a start and a withdrawal date for your
                                    savings plan"
                        titleStyle={this.titleStyle}
                        handlePreviousPage={this.handlePreviousPage}
                        page={this.state.page}

                        handleDurationSubmit={this.handleDurationSubmit}
                        durationFrom={this.state.durationTo}
                        handleDurationFromChange={this.handleDurationFromChange}


                        durationTo={this.state.durationTo}
                        handleDurationToChange={this.handleDurationToChange}
                    />

                );
            default:
                return (
                    <div>
                        <h1>Loading</h1>
                    </div>
                );


        }


    }

}

export default YouthOption;