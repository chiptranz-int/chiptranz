/**
 * Created by MoFoLuWaSo on 9/21/2019.
 */
/**
 * Created by MoFoLuWaSo on 9/21/2019.
 */

import React, {Component} from 'react';
import Domain from '../../scalfolding/Domain.js';
import axios from 'axios';
class Budgeting extends Component {

    constructor(props) {
        super(props);
        this.state = {
            user: {},


        };

        this.domain = new Domain();
        this.retrieveUserInfo = this.retrieveUserInfo.bind(this);
    }


    componentDidMount() {
        this.retrieveUserInfo();
    }

    retrieveUserInfo() {

        axios.get(this.domain.getDomain() + this.domain.youthPlan()).then(function (response) {


            if (response.status == 200) {

                this.setState({
                    user: response.data.user,

                });

            }


        }.bind(this));

    }



    render() {

        return (
            <div>
                <nav aria-label="breadcrumb">
                    <ol className="breadcrumb">
                        <li className="breadcrumb-item "><a href="#">Tools</a></li>
                        <li className="breadcrumb-item active" aria-current="page">Budgeting</li>
                    </ol>
                </nav>

            </div>
        );

    }


}

export default Budgeting;