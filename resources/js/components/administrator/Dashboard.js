/**
 * Created by MoFoLuWaSo on 9/21/2019.
 */
/**
 * Created by MoFoLuWaSo on 9/21/2019.
 */
import React, {Component} from 'react';
import Domain from '../scalfolding/Domain.js';
import axios from 'axios/index';
import {Router, Route, Link} from 'react-router-dom';






class Dashboard extends Component {

    constructor(props) {
        super(props);
        this.state = {
            user: {},

        };





    }


    componentDidMount() {

    }

    retrieveUserInfo() {



    }



    render() {

        return (


            <div>

                <nav aria-label="breadcrumb">
                    <ol className="breadcrumb">
                        <li className="breadcrumb-item "><a href="#">Savings</a></li>
                        <li className="breadcrumb-item active" aria-current="page">Steady Growth</li>
                    </ol>

                </nav>





            </div>
        );

    }


}

export default Dashboard;