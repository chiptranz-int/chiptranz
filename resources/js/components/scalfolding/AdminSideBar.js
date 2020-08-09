/**
 * Created by MoFoLuWaSo on 9/3/2019.
 */
import React, {Component} from 'react';
import  {Router, Route, Link} from 'react-router-dom';
import {createBrowserHistory} from 'history';


class AdminSideBar extends Component {

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
                        <Link className="nav-link" to="/dashboard" onClick={this.handleNavigation}>
                            <i className="mdi mdi-view-dashboard-outline menu-icon"></i>
                            <span className="menu-title">Dashboard</span>
                        </Link>
                    </li>
                    <li className="nav-item">
                        <Link className="nav-link" to="/customers" onClick={this.handleNavigation}>
                            <i className="mdi mdi-account-group menu-icon"></i>
                            <span className="menu-title">Customers</span>
                        </Link>
                    </li>


                </ul>
            </nav>


        );
    }
}

export default AdminSideBar;
