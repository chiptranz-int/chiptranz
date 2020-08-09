/**
 * Created by MoFoLuWaSo on 9/22/2019.
 */

class Domain {

    constructor() {
        this._domain = '';
        this._userUrl = '/home/user';
        this._userKinUrl = '/home/kin';
        this._homeUrl = '/home';
        this._payDetailUrl = '/setup/paystackDetails';
        this._payUrl = '/setup/paymentStack';
        this._paySubUrl = '/setup/paymentStackSubsequent';
        this._youthUrl = '/setup/youthGoalSetup';
        this._steadyUrl = '/setup/steadyGrowthSetup';
        this._planSetupUrl = '/setup/planSetupUrl';
        this._newPlanSetupUrl = '/setup/newPlanSetupUrl';
        this._userSummary = '/home/summary';
        this._steadyPlan = '/home/steadyPlan';
        this._steadySavings = '/home/steadySavings';
        this._youthPlan = '/home/youthPlan';
        this._youthSavings = '/home/youthSavings';
        this._updateYouthGoals = '/home/updateYouthGoals';
        this._updateSteadyGrowth = '/home/updateSteadyGrowth';
        this._getPlans = '/home/getPlans';
        this._saveNow = '/home/saveNow';
        this._payOptions = '/home/payOptions';
        this._removeCard = '/home/removeCard';
        this._sendConfirmation = '/home/sendConfirmation';
        this._createTransferRecipient = '/home/transferRecipient';
        this._userWithdrawals = '/home/userWithdrawals';
        this._initiateTransfer = '/home/initiateTransfer';
    }

    getDomain() {
        return this._domain;
    }

    getHome() {
        return this._homeUrl;
    }

    getUserUrl() {
        return this._userUrl;
    }

    getKinUrl() {
        return this._userKinUrl;
    }

    paystackUrl() {

        return this._payUrl;

    }

    paystackSubsequentUrl() {

        return this._paySubUrl;

    }

    paystackDetailUrl() {

        return this._payDetailUrl;

    }

    steadyGrowthSetupUrl() {

        return this._steadyUrl;

    }

    youthGoalSetupUrl() {

        return this._youthUrl;

    }

    planSetupUrl() {

        return this._planSetupUrl;

    }

    newPlanSetupUrl() {

        return this._newPlanSetupUrl;

    }

    userSummary() {

        return this._userSummary;
    }

    steadyPlan() {
        return this._steadyPlan;
    }

    steadySavings(planId) {
        return this._steadySavings + "/" + planId;
    }

    youthPlan() {
        return this._youthPlan;
    }

    youthSavings(planId) {
        return this._youthSavings + "/" + planId;
    }

    getFrequency(key) {
        let frequency = {
            1: "Daily",
            2: "Weekly",
            3: "Monthly"
        }
        return frequency[key];
    }


    updateYouthGoals() {
        return this._updateYouthGoals;
    }

    updateSteadyGrowth() {
        return this._updateSteadyGrowth;
    }

    getPlans() {
        return this._getPlans;
    }

    saveNow() {
        return this._saveNow;
    }

    payOptions() {
        return this._payOptions;
    }

    removeCard(cardId) {
        return this._removeCard + "/" + cardId;
    }

    sendConfirmationCode() {
        return this._sendConfirmation;
    }

    createTransferRecipient() {

        return this._createTransferRecipient;

    }

    userWithdrawals() {

        return this._userWithdrawals;

    }

    initiateTransfer() {

        return this._initiateTransfer;

    }
}

export default Domain;