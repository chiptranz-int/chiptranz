/**
 * Created by MoFoLuWaSo on 9/21/2019.
 */
/**
 * Created by MoFoLuWaSo on 9/21/2019.
 */

import React, {Component} from 'react';
import Domain from '../../scalfolding/Domain.js';
import axios from 'axios';
import PlanHelper from "../savings/PlanHelper";
import RemoveCardModal from "./RemoveCardModal";
import AddCardModal from "./AddCardModal";
import AddBankModal from "./AddBankModal";
import VerificationCodeModal from "./VerificationCodeModal";


class Payments extends Component {

    constructor(props) {
        super(props);
        this.state = {
            user: {},
            cards: [],
            bank: {},
            banks: [],
            show: false,
            showAdd: false,
            showAddBank: false,
            showCode: false,
            toRemove: {},
            paystack: [],
            code: 0,
            confirmCode: 0,

        };

        this.domain = new Domain();
        this.helper = new PlanHelper();
        this.cardView = this.cardView.bind(this);
        this.bankView = this.bankView.bind(this);
        this.addCard = this.addCard.bind(this);
        this.removeCard = this.removeCard.bind(this);
        this.handleRemoveCard = this.handleRemoveCard.bind(this);
        this.handleAddCard = this.handleAddCard.bind(this);
        this.handleAddBank = this.handleAddBank.bind(this);
        this.handleCloseRemove = this.handleCloseRemove.bind(this);
        this.handleCloseAdd = this.handleCloseAdd.bind(this);
        this.handleCloseAddBank = this.handleCloseAddBank.bind(this);
        this.handlePaySubmit = this.handlePaySubmit.bind(this);
        this.retrievePaystackDetails = this.retrievePaystackDetails.bind(this);
        this.handleAccountNumber = this.handleAccountNumber.bind(this);
        this.handleBankChange = this.handleBankChange.bind(this);
        this.addBank = this.addBank.bind(this);
        this.handleResendCode = this.handleResendCode.bind(this);
        this.handleCodeChange = this.handleCodeChange.bind(this);
        this.handleCloseCode = this.handleCloseCode.bind(this);
        this.handleShowCode = this.handleShowCode.bind(this);
        this.handleVerifyCode = this.handleVerifyCode.bind(this);
        this.getBankView = this.getBankView.bind(this);
    }


    componentDidMount() {
        this.retrieveUserInfo();
    }

    retrieveUserInfo() {

        axios.get(this.domain.getDomain() + this.domain.payOptions()).then(function (response) {


            if (response.status == 200) {

                this.setState({
                    user: response.data.user,
                    cards: response.data.cards,
                    bank: response.data.bank,
                    banks: response.data.banks,

                });

            }


        }.bind(this));

    }

    addCard() {

        this.handlePaySubmit();

    }

    addBank() {

        axios.get(this.domain.getDomain() + this.domain.sendConfirmationCode()).then(function (response) {


            if (response.status == 200) {
                if (response.data.success) {
                    this.setState({
                        code: response.data.code,

                    });

                } else {

                }

            }

        }.bind(this));
        this.handleCloseAddBank();
        this.handleShowCode();
    }

    handleAddCard() {
        this.retrievePaystackDetails();
        this.setState({
            showAdd: true,

        });
    }
    handleShowCode() {

        this.setState({
            showCode: true,

        });
    }

    handleAddBank() {
        // this.retrievePaystackDetails();
        this.setState({
            showAddBank: true,

        });
    }

    handleCodeChange(code) {

        this.setState({
            confirmCode: code,

        });
    }

    handleVerifyCode() {


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
            this.setState({
                accountMessage: 'Wrong verification code. Please try again',
            });
        }
    }

    handleResendCode() {
        this.setState({
            accountMessage: 'Re-sending verification code. Please Wait.',
        });
        axios.get(this.domain.getDomain() + this.domain.sendConfirmationCode()).then(function (response) {


            if (response.status == 200) {
                if (response.data.success) {
                    this.setState({
                        code: response.data.code,
                        accountMessage: 'Verification code successfully sent to your mobile number.',
                    });

                } else {
                    this.setState({

                        accountMessage: 'Error sending verification code, please try again.',
                    });
                }

            }

        }.bind(this));
    }

    handleRemoveCard(card) {
        let length = this.state.cards.length;

        if (length < 2) {
            this.setState({
                message: "Please Add another card before you remove existing card on your Savings",

            });

        } else {
            this.setState({
                show: true,
                toRemove: card,
            });
        }

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


                axios.get(this.domain.getDomain() + this.domain.paystackSubsequentUrl() + '/' + response.reference).then(
                    function (resp) {

                        if (resp.status == 200) {

                            this.setState({
                                user: resp.data.user,
                                cards: resp.data.cards,
                                bank: resp.data.bank,
                                banks: resp.data.banks,
                                showAdd: false,
                                message: 'Card Processed Successfully',
                            });


                        }

                    }.bind(this));


            }.bind(this),
            onClose: function () {
//                    alert('window closed');
                //here go to the db and remove any account that does not have card registered
            }
        });
        handler.openIframe();

    }

    handleCloseRemove() {
        this.setState({
            show: false,
        });
    }

    handleCloseAdd() {
        this.setState({
            showAdd: false,
        });
    }

    handleCloseAddBank() {
        this.setState({
            showAddBank: false,
        });
    }
    handleCloseCode() {
        this.setState({
            showCode: false,
        });
    }

    removeCard() {
        axios.get(this.domain.getDomain() + this.domain.removeCard(this.state.toRemove)).then(function (response) {


            if (response.status == 200) {

                this.setState({
                    user: response.data.user,
                    cards: response.data.cards,
                    bank: response.data.bank,
                    banks: response.data.banks,
                    message: 'Card Removed Successfully',
                    show: false,
                });

            }


        }.bind(this));
    }

    cardView() {
        return (
            <div className="mb-3">
                <div className="card">
                    <div className="card-body">
                        <div className="card-title"> Cards</div>
                        <p className="text-info col-sm text-center ">{this.state.message}</p>
                        <div className="mb-3">
                            <button onClick={this.handleAddCard} className="btn btn-primary">Add New Card</button>
                        </div>
                        <div className="row">
                            {this.state.cards.map(function (card) {

                                return (
                                    <div key={card.id} className="card col-md-4 bg-gradient-warning mb-3 ">
                                        <div className="card-body">
                                            <p className="h5 text-white mb-5">{this.helper.filterCard(card)} </p>
                                            <p className="mb-2">{this.helper.determineExpiryDate(card)}</p>
                                            <a className="text-right small btn"
                                               onClick={() => this.handleRemoveCard(card)}>Remove Card</a>
                                        </div>

                                    </div>
                                );
                            }.bind(this))}


                        </div>
                    </div>
                </div>

                <RemoveCardModal
                    show={this.state.show}
                    handleCloseRemove={this.handleCloseRemove}
                    removeCard={this.removeCard}
                    onHide={this.handleCloseRemove}

                />
                <AddCardModal
                    show={this.state.showAdd}
                    showAdd={this.state.showAdd}
                    handleCloseAdd={this.handleCloseAdd}
                    addCard={this.addCard}
                    onHide={this.handleCloseAdd}


                />


            </div>
        );
    }


    handleAccountNumber(number) {
        let oldBank = this.state.bank;
        oldBank['account_number'] = number;
        this.setState({
            bank: oldBank,
        });

    }

    handleBankChange(code) {
        let oldBank = this.state.bank;
        oldBank['bank_code'] = code;
        this.setState({
            bank: oldBank,
        });
    }

    getBankView() {

        if (this.state.bank == null) {

            return (<div className="card">
                <div className="card-body">
                    <div className="card-title"> Bank</div>
                    <p className="text-info col-sm text-center ">{this.state.accountMessage}</p>
                    <div className="mb-3">
                        <button onClick={this.handleAddBank} className="btn btn-primary">Add Bank Information</button>
                    </div>


                </div>
            </div>);

        } else {

            return (<div className="card">
                <div className="card-body">
                    <div className="card-title"> Bank</div>
                    <p className="text-info col-sm text-center ">{this.state.accountMessage}</p>
                    <div className="mb-3">
                        <button onClick={this.handleAddBank} className="btn btn-primary">Update Bank Information
                        </button>
                    </div>


                    <div className="row">


                        <div className="card col-md-4 bg-gradient-info mb-3 ">
                            <div className="card-body">
                                <p className="h5 text-white mb-5">{this.helper.filterBank(this.state.bank.bank_code,this.state.banks)} </p>

                                <p className="mb-2 text-white">{this.state.bank.account_name}</p>
                                <p className="mb-2 text-right text-white">{this.state.bank.account_number}</p>

                            </div>

                        </div>


                    </div>
                </div>
            </div>);
        }
    }


    bankView() {
        return (
            <div className="mb-3">

                {this.getBankView()}

                <AddBankModal
                    show={this.state.showAddBank}
                    showAddBank={this.state.showAddBank}
                    handleCloseAddBank={this.handleCloseAddBank}
                    addBank={this.addBank}
                    onHide={this.handleCloseAddBank}
                    banks={this.state.banks}
                    bank={this.state.bank}
                    handleAccountNumber={this.handleAccountNumber}
                    handleBankChange={this.handleBankChange}

                />

                <VerificationCodeModal
                    show={this.state.showCode}
                    showCode={this.state.showCode}
                    handleCloseCode={this.handleCloseCode}
                    handleResendCode={this.handleResendCode}
                    onHide={this.handleCloseCode}
                    handleCodeChange={this.handleCodeChange}
                    handleVerifyCode={this.handleVerifyCode}
                    accountMessage={this.state.accountMessage}

                />


            </div>
        );
    }


    render() {

        return (
            <div>
                <nav aria-label="breadcrumb">
                    <ol className="breadcrumb">
                        <li className="breadcrumb-item "><a href="#">Settings</a></li>
                        <li className="breadcrumb-item active" aria-current="page">Payments</li>
                    </ol>
                </nav>

                {this.cardView()}
                {this.bankView()}


            </div>
        );

    }


}

export default Payments;