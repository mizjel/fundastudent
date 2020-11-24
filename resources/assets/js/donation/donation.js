$( document ).ready(function() {

    var donation = (function () {

        // -- Settings --
        var settings = {
            inputs : {
                amount: $('#amount'),
                email: $('#email'),
                name: $('#name'),
                message: $('#message'),
                transaction_costs: $('#transaction_costs'),
            },
            label_total : $('#label_total'),
        };


        // -- SETUP functions --
        var _setDefaults = function () {
            _amount.setText();
        }

        var _bindUIActions = function () {
            settings.inputs.amount.on('change', function(){
                _amount.changed($(this).val());
            });

            settings.inputs.transaction_costs.on('click', function () {
                _transaction_costs.changed($(this).val());
            });
        };

        var init = function () {
            _bindUIActions();
            _setDefaults();
        }


        // -- Functions --
        var _amount = {
            setText : function (){
                //Add the amount and transaction costs
                var txt_amount = this.convertToFloat(this.getAmount()) + this.convertToFloat(_transaction_costs.getCost());

                //Set text
                settings.label_total.text('Totaal: €' + txt_amount.toFixed(2).replace(".", ","));
            },
            getAmount : function (){
                return settings.inputs.amount.val();
            },
            changed : function () {
                //Replace dots with comma in input field. Just for user friendly experiences
                settings.inputs.amount.val(settings.inputs.amount.val().replace(/\./g,','));

                this.setText();
            },
            convertToFloat : function (amount){
                return parseFloat(amount.replace(",", "."));
            }
        };

        var _transaction_costs = {
            getCost : function () {
                return transaction_costs;
            },
        };


        return {
            init: init,
        }

    })();

    donation.init();

});