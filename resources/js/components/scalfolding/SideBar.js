/**
 * Created by MoFoLuWaSo on 9/3/2019.
 */
import React, {Component} from 'react';
import  {Router, Route, Link} from 'react-router-dom';
import {createBrowserHistory} from 'history';


class SideBar extends Component {

    constructor(props) {
        super(props);


    }


    handleSavingsCollapse(e) {
        e.target.classList.toggle("collapsed");
        let expand = e.target.toggleAttribute("aria-expanded");

        let saveLink = document.querySelector("#ui-basic");
        saveLink.classList.toggle("collapse");
        saveLink.classList.toggle("show");

    }

    handleToolsCollapse(e) {
        e.target.classList.toggle("collapsed");
        let expand = e.target.toggleAttribute("aria-expanded");

        let saveLink = document.querySelector("#ui-advanced");
        saveLink.classList.toggle("collapse");
        saveLink.classList.toggle("show");

    }

    handleSettingsCollapse(e) {
        e.target.classList.toggle("collapsed");
        let expand = e.target.toggleAttribute("aria-expanded");

        let saveLink = document.querySelector("#form-elements");
        saveLink.classList.toggle("collapse");
        saveLink.classList.toggle("show");

    }

    handleNavigation(e) {

        try {
            let currentActive = document.querySelector("li.active");
            currentActive.classList.remove('active');


            e.target.parentElement.parentElement.classList.add("active");
            e.target.parentElement.parentElement.parentElement.parentElement.classList.add("active");
        } catch (e) {

        }
        e.target.parentElement.classList.add("active");
    }

    handleSubNavigation(e) {

        try {
            let currentActive = document.querySelector("li.active");
            currentActive.classList.remove('active');


            e.target.parentElement.parentElement.classList.add("active");
            e.target.parentElement.parentElement.parentElement.parentElement.classList.add("active");
        } catch (e) {

        }
        // e.target.parentElement.classList.add("active");
    }


    render() {
        return (



            <nav className="sidebar sidebar-offcanvas " id="sidebar">
                <ul className="nav">
                    <li className="nav-item active">
                        <Link className="nav-link" to="/home" onClick={this.handleNavigation}>
                            <i className="mdi mdi-view-dashboard-outline menu-icon"></i>
                            <span className="menu-title">Summary</span>
                        </Link>
                    </li>
                    <li className="nav-item">
                        <Link className="nav-link" to="/activity" onClick={this.handleNavigation}>
                            <i className="mdi mdi-airplay menu-icon"></i>
                            <span className="menu-title">Activity</span>
                        </Link>
                    </li>
                    <li className="nav-item" >
                        <Link className="nav-link" to="/save" onClick={this.handleNavigation}>
                            <i className="mdi mdi-content-save menu-icon"></i>
                            <span className="menu-title">Save Now</span>
                        </Link>
                    </li>
                    <li className="nav-item">
                        <a className="nav-link" onClick={this.handleSavingsCollapse} data-toggle="collapse"
                           href="#ui-basic" id="ui-basic" aria-expanded="false" aria-controls="ui-basic">
                            <i className="mdi mdi-credit-card menu-icon"></i>
                            <span className="menu-title">Savings</span>
                            <i className="menu-arrow"></i>
                        </a>
                        <div className="collapse" id="ui-basic">
                            <ul className="nav flex-column sub-menu">
                                <li className="nav-item">
                                    <Link onClick={this.handleSubNavigation} className="nav-link" to="/new-plan">
                                        New Plan
                                    </Link>
                                </li>
                                <li className="nav-item"><Link onClick={this.handleSubNavigation} className="nav-link"
                                                               to="/youth-goals">Youth
                                    Goals</Link></li>
                                <li className="nav-item">
                                    <Link onClick={this.handleSubNavigation} className="nav-link"
                                                               to="/steady-growth">
                                    Steady Growth</Link>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li className="nav-item">
                        <Link className="nav-link" to="/withdrawal" onClick={this.handleNavigation}>
                            <i className="mdi mdi-account-box-outline menu-icon"></i>
                            <span className="menu-title">Withdrawals</span>
                        </Link>
                    </li>
                    <li className="nav-item">
                        <a className="nav-link" onClick={this.handleToolsCollapse} data-toggle="collapse"
                           id="ui-advanced"
                           href="#ui-advanced" aria-expanded="false"
                           aria-controls="ui-advanced">
                            <i className="mdi mdi-toolbox menu-icon"></i>
                            <span className="menu-title">Tools</span>
                            <i className="menu-arrow"></i>
                        </a>
                        <div className="collapse" id="ui-advanced">
                            <ul className="nav flex-column sub-menu">
                                <li className="nav-item">
                                    <Link className="nav-link" to="/calculator">Budgeting</Link>
                                </li>


                            </ul>
                        </div>
                    </li>
                    <li className="nav-item">
                        <a className="nav-link" onClick={this.handleSettingsCollapse} data-toggle="collapse"
                           href="#form-elements" id="form-elements" aria-expanded="false"
                           aria-controls="form-elements">
                            <i className="mdi mdi-settings menu-icon"></i>
                            <span className="menu-title">Settings</span>
                            <i className="menu-arrow"></i>
                        </a>
                        <div className="collapse" id="form-elements">
                            <ul className="nav flex-column sub-menu">
                                <li className="nav-item"><Link className="nav-link" to="/personal">Personal</Link>
                                </li>
                                <li className="nav-item"><Link className="nav-link" to="/next-kin">Next of Kin</Link>
                                </li>
                                <li className="nav-item"><Link className="nav-link" to="/security">Security</Link>
                                </li>
                                <li className="nav-item"><Link className="nav-link" to="/payments">Payments</Link>
                                </li>
                            </ul>
                        </div>
                    </li>

                </ul>
            </nav>


        );
    }
}

export default SideBar;
