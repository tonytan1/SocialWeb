/**
 * Created by tonytan on 5/10/2015.
 */

function O(obj){ //object
    if(typeof obj == 'object') return obj;
    else return document.getElementById(obj);
}

function S(obj){ //style
    return O(obj).style;
}

function C(name){ // class
    var elements = document.getElementsByTagName('*');
    var objects = [];

    for(var i=0; i<elements.length; ++i){
        if(elements[i].className == name)
            objects.push(elements[i]);
    }
    return objects;
}
