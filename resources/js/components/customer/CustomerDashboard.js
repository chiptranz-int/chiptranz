/**
 * Created by MoFoLuWaSo on 9/21/2019.
 */

import React, {Component} from 'react';
import Header from '../scalfolding/Header';
import Footer from '../scalfolding/Footer';
import SideBar from '../scalfolding/SideBar';
import Activity from './Activity';
import Summary from './Summary';

import YouthGoals from './savings/YouthGoals';
import SteadyGrowth from './savings/SteadyGrowth';
import PlanOptions from './new-plan/PlanOptions';


import Personal from './settings/Personal';
import Payments from './settings/Payments';
import Security from './settings/Security';
import NextKin from './settings/NextKin';

import Budgeting from './tools/Budgeting';

import Withdrawal from './Withdrawal';

import Save from './Save';


import  {Router, Route, Link} from 'react-router-dom';
import {createBrowserHistory} from 'history';

class CustomerDashboard extends Component {


    constructor(props) {
        super(props);
        this.history = createBrowserHistory();
    }


    render() {
        return (
            <Router history={this.history}>
                <div>
                    <Header />

                    <div className="container-fluid page-body-wrapper">

                        <SideBar />


                        <div className="main-panel">
                            <div className="content-wrapper">


                                <Route path={'/home'} component={Summary}/>

                                <Route path={'/activity'} component={Activity}/>

                                <Route path={'/save'}  component={Save}  />

                                <Route path={'/new-plan'} component={PlanOptions}/>

                                <Route path={'/youth-goals'} component={YouthGoals}/>

                                <Route path={'/steady-growth'} component={SteadyGrowth}/>

                                <Route path={'/withdrawal'} component={Withdrawal}/>

                                <Route path={'/calculator'} component={Budgeting}/>

                                <Route path={'/personal'} component={Personal}/>

                                <Route path={'/next-kin'} component={NextKin}/>

                                <Route path={'/security'} component={Security}/>

                                <Route path={'/payments'} component={Payments}/>


                            </div>

                            <Footer />

                        </div>

                    </div>
                </div>

            </Router>






        );
    }
}

export default CustomerDashboard;