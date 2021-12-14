let hgutil = {
    loadSelectFromArray: function (url, elementId, selectValue, callback) {
        fetch(url)
            .then(function (response) {
                return response.json();
            })
            .then(function (objects) {
                var el = document.getElementById(elementId);
                    el.innerHTML ='';//adet von Remo
                var selectIndex = null;
                if (selectValue === true) {
                    selectIndex = 0;
                }
                
                var counter = 0;debugger
                objects.forEach(function (o) {
                    var option = document.createElement("option");
                    option.text = o;
                    option.value = o;
                    el.appendChild(option);

                    if (selectValue === o) {
                        selectIndex = counter;
                    }
                    counter++;
                });

                if (selectIndex >= 0) {
                    el.selectedIndex = selectIndex;
                }

                if (callback) {
                    callback();
                }
            });
    },
    
    getParameterByName: function(name) {
        var match = RegExp('[?&]' + name + '=([^&]*)').exec(window.location.search);
        return match && decodeURIComponent(match[1].replace(/\+/g, ' '));
    }
};
export default hgutil;