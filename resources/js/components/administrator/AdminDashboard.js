/**
 * Created by MoFoLuWaSo on 9/21/2019.
 */

import React, {Component} from 'react';
import Header from '../scalfolding/Header';
import Footer from '../scalfolding/Footer';
import AdminSideBar from '../scalfolding/AdminSideBar';
import Customers from './Customers';
import Dashboard from './Dashboard';



import  {Router, Route, Link} from 'react-router-dom';
import {createBrowserHistory} from 'history';


class AdminDashboard extends Component {


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

                        <AdminSideBar />


                        <div className="main-panel">
                            <div className="content-wrapper">


                                <Route path={'/home'}  component={Dashboard}/>

                                <Route path={'/customers'} component={Customers}/>


                            </div>

                            <Footer />

                        </div>

                    </div>
                </div>

            </Router>






        );
    }
}

export default AdminDashboard;