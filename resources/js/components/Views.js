/**
 * Created by MoFoLuWaSo on 9/3/2019.
 */
import React, {Component} from 'react';


import Domain from './scalfolding/Domain.js';
import axios from 'axios';
import PlanOptions from './first-customer/PlanOptions';
import CustomerDashBoard from './customer/CustomerDashboard';

import AdminDashboard from './administrator/AdminDashboard';



class Views extends Component {


    constructor(props) {

        super(props);
        this.retrieveUserInfo = this.retrieveUserInfo.bind(this);
        this.getDefaultView = this.getDefaultView.bind(this);

        this.domain = new Domain();

        this.state = {
            user: {},
            page: 0,
        };

    }

    componentDidMount() {

        this.retrieveUserInfo();
    }

    retrieveUserInfo() {

        axios.get(this.domain.getDomain() + this.domain.getUserUrl()).then(function (response) {

            if (response.status == 200) {

                this.setState({
                    user: response.data,
                });

            }


        }.bind(this));

    }


    getDefaultView() {

        //determine if user is an admin or customer

        if (this.state.user.user_type == '0') {

            switch (this.state.user.flag) {

                case 0:

                    return (<PlanOptions user={this.state.user} />);
                case 1:
                    return (<CustomerDashBoard user={this.state.user}/>);

                default:
                    return (<div><h1>Loading...</h1></div>);
            }
        }else if (this.state.user.user_type == '1'){

            return (<AdminDashboard user={this.state.user}/>);

        } else {

            //return (<PlanOptions />);
            return (<div><h1>loading...</h1></div>);

        }


    }


    render() {



        switch (this.state.page) {

            case 0:
                return this.getDefaultView();
        }

    }
}
export default Views;
