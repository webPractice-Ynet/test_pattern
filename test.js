
(function (){
    var generatePermutation = function(perm, pre, post, n) {
        var elem, i, rest, len;
        if (n > 0)
        for (i = 0, len = post.length; i < len; ++i) {
            rest = post.slice(0);
            elem = rest.splice(i, 1);
            generatePermutation(perm, pre.concat(elem), rest, n - 1);
        }
        else
        perm.push(pre);
    };
    var permutation, getCombintion;

    permutation = function(n) {
        if (n == null) n = this.length;
        var perm = [];
        generatePermutation(perm, [], this, n);
        return perm;
    };

    getCombintion = function (permutation_flag = false, constraints = null) {

        var list = this,
            combo_list = [],
            target_data = [],
            last_layer = Object.keys(list).length -1;

        
        if (typeof(permutation_flag) != 'boolean') {

            var type_permutation_flag = typeof(permutation_flag);
            if (type_permutation_flag == 'object' || type_permutation_flag == 'function') {
                constraints = permutation_flag;
            }
        }
        function bootConstraints (constraints, data_pare) {
            var result = true;

            if (typeof(constraints) === 'function') {
                
                result = constraints(data_pare);
            }
            return result;
        }

        function checkConstraints (data_pare) {

            var result = true;
            if (constraints) {
                if (typeof(constraints) === 'object'){
                    var keys = Object.keys(constraints);
                    for (var i = 0; i < keys.length; ++i) {
                        result = bootConstraints(constraints[keys[i]], data_pare);
                        if (result === false) {
                            break;
                        }
                    }
                } else {
                    result = bootConstraints(constraints, data_pare);
                }

                return result;
            } else {
                //制約条件なし
                return true;
            }
        }

        function setComboList (temp) {

            if (checkConstraints(temp) === true) {
                
                
                combo_list.push(temp);
            }
        }

        function innerObject (list) {
            var list_keys = Object.keys(list);

            return function inner(list, now_layer, next_layer) {
                var layer_key = list_keys[now_layer];//key自体を取得

                for (var i = 0; i < list[layer_key].length; ++i) {
                    
                    target_data[layer_key] = list[layer_key][i];
                    
                    if (now_layer === last_layer) {
                        var temp = {};
                        for (var t = 0; t < list_keys.length; ++t) {
                            temp[list_keys[t]] = target_data[list_keys[t]];
                        }

                        if (permutation_flag === true) {
                            temp.permutation().forEach(function(combo){
                                setComboList (temp)
                            });
                        } else {
                            setComboList(temp);
                        }

                    } else {
                        //最深部のループ以外の場合、さらに奥のループ処理へ映る
                        inner(list, next_layer, (next_layer+1));
                    }
                }
            }
           
        }

        function innerArray (list, now_layer, next_layer) {
            list[now_layer].forEach(function(value, key){

                target_data[now_layer] = value;
                
                if (now_layer === last_layer) {
                    var temp = Array.from(target_data);
                    if (permutation_flag === true) {
                        temp.permutation().forEach(function(combo){
                            setComboList (temp)
                        });
                    } else {
                        setComboList (temp);
                    }
                    
                } else {
                    //最深部のループ以外の場合、さらに奥のループ処理へ映る
                    innerArray(list, next_layer, (next_layer+1));
                }
            });
        }
        if (Array.isArray(list)) {
            innerArray(list, 0, 1);
        } else {
            target_data = {};
            innerObject(list)(list, 0, 1);
        }
        
        return combo_list;
    };
    Array.prototype.permutation = permutation;
    Array.prototype.getCombintion = getCombintion;
    Object.prototype.permutation = permutation;
    Object.prototype.getCombintion = getCombintion;

})();

var sample1 = [
    ['cris', 'isabela', 'tarou'],
    ['male', 'female', 'lgbt'],
    ['usa', 'thai', 'japan']
];

var result1 = sample1.getCombintion(function(pare){
    //keyの型に注意 array型のから来ると、keyがstringになっている
    if (pare[0] === 'cris' || pare[0] === 'tarou') {
        
        if (pare[1] == 'female') {
            return false;
        }
    }
    return true;
});

var sample2 = {
    name: ['cris', 'isabela', 'tarou'],
    sex: ['male', 'female', 'lgbt'],
    nation: ['usa', 'thai', 'japan']
};

// var result2 = sample2.getCombintion();
var result2 = sample2.getCombintion(function(pare){
    if (pare['name'] === 'cris' || pare['name'] === 'tarou') {
        if (pare['sex'] != 'male') {
            return false;
        }
    }
    if (pare['name'] === 'isabela') {
        if (pare['sex'] == 'female' && pare['nation'] == 'usa') {
            return true;
        }
        return false;
    }
    return true;
});

// result = sample.getCombintion(false, 
//     [
//         function(value, key){
//             //keyの型に注意 array型のから来ると、keyがstringになっている
//             if (key == 0 ) {
//                 if (value === 'cris') {
//                     return false;
//                 }
//             }
//             return true;
//         },
//         function(value, key){
//             //keyの型に注意 array型のから来ると、keyがstringになっている
//             if (key == 1 ) {
//                 if (value === 'female') {
//                     return false;
//                 }
//             }
//             return true;
//         },
// ]
// );