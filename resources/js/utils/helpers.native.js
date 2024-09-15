/**
 * [description]
 * @param  {[type]} arg [description]
 * @return {[type]}     [description]
 */
export const is_array = (arg) => {
	return Array.isArray(arg);
}

/**
 * [description]
 * @param  {[type]} arg [description]
 * @return {[type]}     [description]
 */
export const is_number = (arg) => {
	return (typeof arg) == 'number' ? true : false;
}

/**
 * [description]
 * @param  {[type]} arg [description]
 * @return {[type]}     [description]
 */
export const is_boolean = (arg) => {
	return (typeof arg) == 'boolean';
}

/**
 * [description]
 * @param  {[type]} arg [description]
 * @return {[type]}     [description]
 */
export const is_function = (arg) => {
	return (typeof arg) === 'function' && Object.getPrototypeOf(arg) === Function.prototype;
}

/**
 * [description]
 * @param  {[type]} arg [description]
 * @return {[type]}     [description]
 */
export const is_async_function = (arg) => {
	return (typeof arg) === 'function' && arg.constructor && arg.constructor.name === "AsyncFunction"
}

/**
 * [description]
 * @param  {[type]} arg [description]
 * @return {[type]}     [description]
 */
export const is_object = (arg) => {
	return arg instanceof Object && !is_array(arg) && !is_function(arg);
}

/**
 * [description]
 * @param  {[type]} arg [description]
 * @return {[type]}     [description]
 */
export const is_string = (arg) => {
	return (typeof arg) == 'string' ? true : false;
}

/**
 * [description]
 * @param  {[type]} obj [description]
 * @return {[type]}     [description]
 */
export const is_class = (obj) => {
	return typeof obj === 'function' && /^\s*class\s+/.test(obj.toString());
}

/**
 * [description]
 * @param  {[type]} arg [description]
 * @return {[type]}     [description]
 */
export const is_undefined = (arg) => {
	return arg === undefined;
}

/**
 * [description]
 * @param  {[type]} obj [description]
 * @param  {[type]} cl  [description]
 * @return {[type]}     [description]
 */
export const is_instance = (obj, cl) => {
	return typeof obj === 'object' ?? (is_class(cl) ? obj instanceof cl : (
		is_string(cl) 
			? Object.prototype.toString.call(obj) == ('[object ' + cl + ']')
			: Object.prototype.toString.call(obj) !== '[object Function]'
	));
}

/**
 * [description]
 * @param  {[type]} obj [description]
 * @return {[type]}     [description]
 */
export const is_regexp = (obj) => {
	return is_object(obj) && obj.constructor.name === 'RegExp';
}

/**
 * [description]
 * @param  {[type]} text [description]
 * @return {[type]}      [description]
 */
export const is_url = (text) => {
	const regexp = /^(http[s]?\:\/\/)?[a-z0-9-]{1,5}\.([a-z0-9-_]+)\.[a-z0-9-]{1,5}(:\d{2,4})?(\/.*)?$|^(http[s]?\:\/\/)?([a-z0-9-_]+)\.[a-z0-9-]{1,5}(:\d{2,4})?(\/.*)?$|^(http[s]?\:\/\/)?([a-z0-9-_]+)\.[a-z0-9-]{1,5}(:\d{2,4})?(\/.*)?$/;
	return regexp.test(text);
	// return /^http[s]?\:\/\/.*|^[a-z0-9-]{1,5}\.([a-z0-9-_]+)\.[a-z0-9-]{1,5}$|^([a-z0-9-_]+)\.[a-z0-9-]{1,5}\/.*$|^([a-z0-9-_]+)\.[a-z0-9-]{1,5}$/i.test(text);
	// return /^(?:\w+:)?\/\/([^\s.]+\.\S{2}|localhost[:?\d]*)\S*$/i.test(text);
}

/**
 * [description]
 * @param  {[type]} first_class [description]
 * @param  {[type]} second_class  [description]
 * @return {[type]}     [description]
 */
export const is_prototype_of = (first_class, second_class) => {
	return first_class.prototype.isPrototypeOf(second_class.prototype);
}

/**
 * [description]
 * @param  {[type]} object [description]
 * @param  {[type]} keys   [description]
 * @return {[type]}        [description]
 */
export const array_get_multiple_key = (object, keys) => {
	keys = is_array(keys) ? keys : [keys];
	if(is_object(object) && object.constructor.length > 0){
		let object_update = object;
		for(let key of keys){
			if(!is_string(key)) return undefined;
			if(object_update[key]) object_update = object_update[key];
			else return undefined;
		}
		return object_update;
	}
}

/**
 * [description]
 * @param  {[type]} str [description]
 * @return {[type]}     [description]
 */
export const to_camel_case = (str) => {
	// Convertit Snake Case et Pascal Case en Camel Case
	const snakePascalCaseRegEx = /(?:^\w|[A-Z]|\b\w|[-_])/g;
	const camelCaseStr = str.replace(snakePascalCaseRegEx, (word, index) => {
		if (index === 0) {
			return word.toLowerCase();
		} else {
			return word.toUpperCase().replace(/[-_]/, '');
		}
	});

	// Convertit Kebab Case et Train Case en Camel Case
	const kebabTrainCaseRegEx = /[-\s]/g;
	const finalCamelCaseStr = camelCaseStr.replace(kebabTrainCaseRegEx, '');

	return finalCamelCaseStr;
}

/**
 * [description]
 * @param  {[type]} str [description]
 * @return {[type]}     [description]
 */
export const to_pascal_case = (str) => {
	// Convertit Camel Case et Snake Case en Pascal Case
	const camelSnakeCaseRegEx = /(?:^\w|[A-Z]|\b\w|[-_])/g;
	const pascalCaseStr = str.replace(camelSnakeCaseRegEx, (word) => {
		return word.toUpperCase().replace(/[-_]/, '');
	});

	// Convertit Kebab Case et Train Case en Pascal Case
	const kebabTrainCaseRegEx = /[-\s]/g;
	const finalPascalCaseStr = pascalCaseStr.replace(kebabTrainCaseRegEx, '');

	return finalPascalCaseStr;
}

/**
 * [description]
 * @param  {[type]} str [description]
 * @return {[type]}     [description]
 */
export const to_snake_case = (str) => {
	// Convertit Camel Case et Pascal Case en Snake Case
	const camelPascalCaseRegEx = /(?:^\w|[A-Z]|\b\w)/g;
	const snakeCaseStr = str.replace(camelPascalCaseRegEx, (word, index) => {
		return index === 0 ? word.toLowerCase() : '_' + word.toLowerCase();
	});

	// Convertit Kebab Case et Train Case en Snake Case
	const kebabTrainCaseRegEx = /[-\s]/g;
	const finalSnakeCaseStr = snakeCaseStr.replace(kebabTrainCaseRegEx, '_');

	return finalSnakeCaseStr;
}

/**
 * [description]
 * @param  {[type]} str [description]
 * @return {[type]}     [description]
 */
export const to_kebab_case = (str) => {
	// Convertit Camel Case, Snake Case et Pascal Case en Kebab Case
	const camelSnakePascalCaseRegEx = /(?:^\w|[A-Z]|\b\w|[-_])/g;
	const kebabCaseStr = str.replace(camelSnakePascalCaseRegEx, (word) => {
		return '-' + word.toLowerCase();
	});

	// Convertit Train Case en Kebab Case
	const trainCaseRegEx = /\s/g;
	const finalKebabCaseStr = kebabCaseStr.replace(trainCaseRegEx, '-');

	return finalKebabCaseStr;
}

/**
 * [description]
 * @param  {[type]} str [description]
 * @return {[type]}     [description]
 */
export const to_train_case = (str) => {
	// Convertit Camel Case, Snake Case et Pascal Case en Train Case
	const camelSnakePascalCaseRegEx = /(?:^\w|[A-Z]|\b\w|[-_])/g;
	const trainCaseStr = str.replace(camelSnakePascalCaseRegEx, (word) => {
		return ' ' + word.toUpperCase();
	});

	// Convertit Kebab Case en Train Case
	const kebabCaseRegEx = /-/g;
	const finalTrainCaseStr = trainCaseStr.replace(kebabCaseRegEx, ' ');

	return finalTrainCaseStr.trim();
}

/**
 * [description]
 * @param  {[type]} str [description]
 * @return {[type]}     [description]
 */
export const preg_quote = (str) => {
	return str.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
}

/**
 * [description]
 * @param  {[type]} text    [description]
 * @param  {[type]} search  [description]
 * @param  {[type]} replace [description]
 * @return {[type]}         [description]
 */
export const replace_text = (text, search, replace) => {
	const regex = new RegExp(preg_quote(search), 'g');
	const nouveauTexte = text.replace(regex, replace);
	return nouveauTexte;
}

/**
 * [description]
 * 
 * @param  {[type]} key [description]
 * @param  {[type]} val [description]
 * @return {[type]}     [description]
 */
export const array_key_exists = (key, object) => {
	return object.hasOwnProperty(key);
}

/**
 * [description]
 * 
 * @param  {[type]} max [description]
 * @param  {[type]} min [description]
 * @return {[type]}     [description]
 */
export const random_int = (min, max) => {
	min = Math.ceil(min);
	max = Math.floor(max);
	return Math.floor(Math.random() * (max - min + 1)) + min;
}

/**
 * [description]
 * @param  {[type]} _class [description]
 * @param  {[type]} method [description]
 * @return {[type]}        [description]
 */
export const method_exists = (_class, method) => {
	return _class[method] && is_function(_class[method]) ? true : false
}

/**
 * [description]
 * @param  {[type]} _class [description]
 * @param  {[type]} method [description]
 * @return {[type]}        [description]
 */
export const all_method_exists = (_class, method) => {
	if((!is_object(_class) && !is_function(_class) && !is_class(_class)) || !is_string(method)) return {test : false, callWith : null};
	let base = method_exists(_class, method), is_static_cl = is_class(_class), val = base
		? true
		: (is_static_cl
			? (method in _class.prototype && typeof _class.prototype[method] === 'function') // static : instance method
			: (_class.constructor[method] && typeof _class.constructor[method] === 'function' ? true : false) // instance : static method
		)
	;
	return {test : val, callWith : val 
		? (
			(base && !is_static_cl) || (!base && is_static_cl)
				? 'instance'
				: 'static'
		) 
		: null 
	};
}

/**
 * [description]
 * @param  {[type]} _class       [description]
 * @param  {[type]} _is_instance [description]
 * @return {[type]}              [description]
 */
export const get_class_name = (_class, _is_instance) => {
	return is_instance(_class) || _is_instance === true 
		? _class.constructor.name
		: (
			_class.getClassName
				? _class.getClassName()
				: _class.name
		)
	;
}

export const get_parent_class = (instance) => {
	var prototype = Object.getPrototypeOf(instance);
	return Object.getPrototypeOf(prototype).constructor;
}

/**
 * [description]
 * @param  {[type]} stack       [description]
 * @param  {[type]} regexp      [description]
 * @param  {[type]} separate    [description]
 * @param  {[type]} stack_error [description]
 * @return {[type]}             [description]
 */
export const get_instruction_line = (stack, regexp, separate, stack_error) => {
	stack = stack ?? 2;
	// regexp = is_array(regexp) && regexp[0] && regexp[1] && is_regexp(regexp[0]) && is_number(regexp[1]) ? regexp : 
	regexp = is_regexp(regexp) 
		? [regexp, 1] 
		: (is_array(regexp) && regexp[0] && is_regexp(regexp[0])
			? [regexp[0], (regexp[1] || regexp[1] === 0) && is_number(regexp[1]) ? regexp[1] : (is_function(regexp[1]) ? regexp[1] : 1)]
			: [/.*at (.*)/i, 1]
		)
	;
	const stackTrace = stack_error ?? new Error().stack, match = stackTrace.split("\n")[stack].match(regexp[0]);
	let lineNumber;
	if(match && is_array(match))
		lineNumber = is_function(regexp[1]) ? regexp[1](match) : match[regexp[1]];
	if(separate && lineNumber){
		const sep = lineNumber.split(':');
		lineNumber = {column : sep.pop(), line : sep.pop(), file : sep.join(':'), 'match' : match};
	}
	return lineNumber;
}

/**
 * [description]
 * @param  {[type]} text     [description]
 * @param  {[type]} color    [description]
 * @param  {[type]} bg_color [description]
 * @param  {[type]} style    [description]
 * @return {[type]}          [description]
 */
export const colorizeText = (text, color, bg_color, style) => {

	style = style ?? 'reset';

	// Codes d'échappement ANSI pour les styles de texte
	const styles = {
		reset: "\x1b[0m",
		bold: "\x1b[1m",
		dim: "\x1b[2m",
		italic: "\x1b[3m",
		underline: "\x1b[4m",
		blink: "\x1b[5m",
		reverse: "\x1b[7m",
		hidden: "\x1b[8m",
	};

	// Codes d'échappement ANSI pour les couleurs du texte
	const textColors = {
		black: "\x1b[30m",
		red: "\x1b[31m",
		green: "\x1b[32m",
		yellow: "\x1b[33m",
		blue: "\x1b[34m",
		magenta: "\x1b[35m",
		cyan: "\x1b[36m",
		white: "\x1b[37m",
		gray: "\x1b[90m",
		brightRed: "\x1b[91m",
		brightGreen: "\x1b[92m",
		brightYellow: "\x1b[93m",
		brightBlue: "\x1b[94m",
		brightMagenta: "\x1b[95m",
		brightCyan: "\x1b[96m",
		brightWhite: "\x1b[97m",
	};

	// Codes d'échappement ANSI pour les couleurs d'arrière-plan
	const backgroundColors = {
		black: "\x1b[40m",
		red: "\x1b[41m",
		green: "\x1b[42m",
		yellow: "\x1b[43m",
		blue: "\x1b[44m",
		magenta: "\x1b[45m",
		cyan: "\x1b[46m",
		white: "\x1b[47m",
		gray: "\x1b[100m",
		brightRed: "\x1b[101m",
		brightGreen: "\x1b[102m",
		brightYellow: "\x1b[103m",
		brightBlue: "\x1b[104m",
		brightMagenta: "\x1b[105m",
		brightCyan: "\x1b[106m",
		brightWhite: "\x1b[107m",
	};

	return (styles[style] ?? '') + (textColors[color] ?? '') + (backgroundColors[bg_color] ?? '') + text + (styles.reset ?? '');
}

/**
 * [description]
 * @param  {[type]} arg [description]
 * @return {[type]}     [description]
 */
export const count = (arg) => {
	return is_array(arg) ? arg.length : (is_object(arg) ? Object.keys(arg).length : undefined);
}

/**
 * [description]
 * @param  {[type]} arg    [description]
 * @param  {[type]} regexp [description]
 * @return {[type]}        [description]
 */
export const transformStringValue = (arg, regexp) => {
	let data = {}, tmp = arg.match(regexp ?? Argv.regexp.arg);
	data[tmp[3] ? tmp[3] : tmp[1]] = {original : tmp[2], convert : Argv.getValueType(tmp[2]), arg : arg};
	return data;
}

/**
 * [description]
 * @param  {[type]} regexp        [description]
 * @param  {[type]} value         [description]
 * @param  {[type]} replace_value [description]
 * @return {[type]}               [description]
 */
export const preg_replace_all = (regexp, value, replace_value) => {
	return (is_string(value) || is_number(value)) && (is_string(replace_value) || is_number(replace_value)) && is_regexp(regexp) ? value.replace(new RegExp(regexp, "g"), replace_value) : null;
}

/**
 * [description]
 * @param  {[type]} value  [description]
 * @param  {[type]} regexp [description]
 * @param  {[type]} key    [description]
 * @return {[type]}        [description]
 */
export const reg_match = (value, regexp, key) => {
	value = is_regexp(regexp) && is_string(value) ? value.match(regexp) : false;
	return is_array(value) ? (key || key === 0 ? (value[key] ?? false) : value) : value;
}

/**
 * [description]
 * @param  {...[type]} value [description]
 * @return {[type]}          [description]
 */
export const dump = (...value) => {
	console.log("\n" + colorizeText(get_instruction_line(3), 'gray'));
	console.log(...value);
}

/**
 * [description]
 * @param  {...[type]} value [description]
 * @return {[type]}          [description]
 */
export const dd = (...value) => {
	console.log("\n" + colorizeText(get_instruction_line(3), 'gray'));
	for(var val of value) console.log(val);
	if(process) process.exit();
}

/**
 * [description]
 * @param  {[type]} path [description]
 * @param  {[type]} root [description]
 * @return {[type]}      [description]
 */
export const relative_path = (path, root) => {
	const match = path.match(new RegExp(preg_quote(root ? root : ROOT) + '[\\/\\\\]{0,1}(.*)$', 'i'));
	return match && match[1] ? match[1] : path;
}

/**
 * [description]
 * @param  {[type]} value [description]
 * @param  {[type]} level [description]
 * @return {[type]}       [description]
 */
export const leading_zero = (value, level) => {
	level_int = parseInt(level ?? 10);
	return parseInt(value) < level_int
		? ('0'.repeat((new String(level_int)).length - (new String(value)).length) + value)
		: value
	;
}


/**
 * [description]
 * @param  {[type]} text1     [description]
 * @param  {[type]} text2     [description]
 * @param  {[type]} separator [description]
 * @param  {[type]} oneline   [description]
 * @param  {[type]} color     [description]
 * @param  {[type]} addition  [description]
 * @return {[type]}           [description]
 */
export const console_two_end_text = (text1, text2, separator, oneline, color, addition) => {
	let columns = process.stdout.columns, sm_txt = text1.length + text2.length, verf = ((sm_txt + 3) <= columns) ? true : false, res;
	separator = separator ?? '.';
	color = color ? (is_array(color) ? color : color.split('|')) : undefined;
	text1 = colorizeText(text1, color && color[0] ? color[0] :null);
	text2 = colorizeText(text2, color && color[2] ? color[2] :null);
	if(oneline === true || verf){
		separator = verf === true ? colorizeText(separator.repeat((columns - sm_txt) + (is_number(addition) ? addition : 0)), (color && color[1] ? color[1] : null)) : '...';
		res = text1 + separator + text2;
	}
	else{
		res = text1 + "\n.\n.\n.\n" + text2;
	}
	return res;
}

/**
 * [description]
 * @param  {[type]} str   [description]
 * @param  {[type]} type  [description]
 * @param  {[type]} space [description]
 * @return {[type]}       [description]
 */
export const format_console_text = (str, type, space) => {

	let columns = process.stdout.columns;

	str = str.split("\n");

	let words = [], l_p = [], i = 0;

	space = space ?? ' '.repeat(2);

	for(let key in str){

		let sep = str[key].split(" "), max_words_size = 0, words_interval = {}, word_tmp_position;

		for(let word_position in sep){

			word = sep[word_position];

			max_words_size += word.length + 1;

			if(count(words_interval) == 0){

				words_interval[0] = null;

				word_tmp_position = 0;

			}


			if(max_words_size > (columns - (space.length * 2))){

				words_interval[word_tmp_position] = word_position;

				words_interval[word_position] = null;

				word_tmp_position = word_position;

				max_words_size = word.length + 1

			}

		}

		if(max_words_size != 0)

			words_interval[word_tmp_position] = count(sep);

		for(let debut in words_interval){

			let fin = words_interval[debut], str = sep.slice(debut, fin).join(" "), str_spaced = (space + str + space);

			words.push(str_spaced);

			if(count(l_p) == 0 || l_p[0] < str_spaced.length){

				if(count(l_p) != 0 && words[l_p[1]])

					words[l_p[1]] = words[l_p[1]] + (space[0] ? space[0].repeat(columns - (words[l_p[1]].length + 1)) : "");

				l_p[0] = str_spaced.length; // taille

				l_p[1] = i; // clé

			}

			else words[i] = words[i] + (space[0] ? space[0].repeat(columns - (words[i].length + 1)) : "");

			i++;

		}

	}

	return type !== undefined ? (type == 1

		? (space[0] ? space[0].repeat(l_p[0]) : "") + "\n" + words.join("\n" + (space[0] ? space[0].repeat(l_p[0]) : "") + "\n") + "\n" + (space[0] ? space[0].repeat(l_p[0]) : "")

		: words.join("\n")

	) : (space[0] ? space[0].repeat(l_p[0]) : "") + "\n" + words.join("\n") + "\n" + (space[0] ? space[0].repeat(l_p[0]) : "");

}

/**
 * [description]
 * @param  {[type]} array [description]
 * @return {[type]}       [description]
 */
export const array_unique = (array) => {
	return is_array(array) ? [...new Set(array)] : array;
}

/**
 * [description]
 * @param  {[type]} arg [description]
 * @return {[type]}     [description]
 */
export const empty = (arg) => {
	return (is_string(arg) && arg.trim() == '') || (count(arg) == 0) || (is_undefined(arg) || arg === null)
		? true
		: false
	;
}

/**
 * [description]
 * @param  {[type]} arg [description]
 * @return {[type]}     [description]
 */
export const object_values = (arg) => {
	return is_object(arg) ? Object.values(arg) : null;
}


/**
 * [description]
 * 
 * @param  {[type]} klass [description]
 * @return {[type]}       [description]
 */
export const getAllInstanceMethods = (klass) => {
	let methods = new Set();
	let current = klass.prototype;

	while (current !== Object.prototype) {
		Object.getOwnPropertyNames(current).forEach(prop => {
			if (typeof current[prop] === 'function') {
				methods.add(prop);
			}
		});
		current = Object.getPrototypeOf(current);
	}

	return Array.from(methods);
}

/**
 * [description]
 * 
 * @param  {[type]} klass [description]
 * @return {[type]}       [description]
 */
export const getAllStaticMethods = (klass) => {
	let methods = new Set();
	let current = klass;

	while (current !== Function.prototype) {
		Object.getOwnPropertyNames(current).forEach(prop => {
			if (typeof current[prop] === 'function' && prop !== 'prototype' && prop !== 'name' && prop !== 'length') {
				methods.add(prop);
			}
		});
		current = Object.getPrototypeOf(current);
	}

	return Array.from(methods);
}

/**
 * [description]
 * 
 * @param  {[type]} str
 * @return {[type]}
 */
export const nl2br = (str) => !is_string(str) ? '' : str.replace(/\n/g, '<br>');

/**
 * [description]
 * 
 * @param  {[type]} target_
 * @param  {[type]} source
 * @param  {[type]} clone
 * @return {[type]}
 */
export const object_merge_recursive = (target_, source, clone = true) => {
	let target = clone ? {...target_} : target_;
	for (let key in source) {
		// Si la valeur est un objet (et pas un tableau ou une fonction)
		if (
			source[key] !== null &&
			typeof source[key] === 'object' &&
			!Array.isArray(source[key]) &&
			typeof source[key] !== 'function'
		) {
			// Si la propriété n'existe pas dans target, on crée un objet vide
			if (!target[key] || typeof target[key] !== 'object' || Array.isArray(target[key])) {
				target[key] = {};
			}
			// Fusionner récursivement les objets
			object_merge_recursive(target[key], source[key], false);
		} else {
			// Pour les autres types (y compris les tableaux), on remplace la valeur
			target[key] = source[key];
		}
	}
	return target;
}

/**
 * [description]
 * 
 * @param  {[type]} arr
 * @param  {[type]} default_value
 * @return {[type]}
 */
export const convertToAssociativeArray = (arr, default_value = undefined) => {
	return arr.reduce((acc, curr) => {
		acc[curr] = default_value;
		return acc;
	}, {});
}

/**
 * [description]
 * 
 * @param  {[type]} size
 * @param  {[type]} min
 * @param  {[type]} max
 * @return {[type]}
 */
export const generateRandomArray = (size, min, max) => {
	let randomArray = [];
	for (let i = 0; i < size; i++) randomArray.push(random_int(min, max));
	return randomArray;
}

/**
 * [formatPaginate description]
 * 
 * @param  {int}    per_level
 * @param  {int}    level
 * @param  {int}    total
 * @param  {array}  datas
 * @param  {bool}   page_notation
 * @param  {int}    offset
 * 
 * @return array
 */
export const format_paginate = (datas, per_page, page, options) => {
	let {total, level_notation, offset} = {
		...(is_object(options) ? options : {})
	};
	page = page ?? 1;
	offset = offset ?? (page - 1) * per_page;
	total = total ?? (datas && is_array(datas) ? datas.length : total)

	let resp = {}, total_pages = Math.ceil(total / per_page), to = per_page * page, p = !level_notation ? 'page' : 'level';
	
	resp[!level_notation ? 'current_page' : 'level'] = page; // ------------------------------- current_page
	resp['per_' + p] = per_page; // ----------------------- per_page (limit)
	resp['total_' + (!level_notation ? 'pages' : 'levels')] = total_pages // --- total_pages
	resp['total_datas'] = total; // ------------------------- total - items count(datas)
	resp['from'] = offset + 1;
	resp['previous_' + p] = page == 1 ? null : page - 1;
	resp['next_' + p] = page == total_pages ? null : page + 1;
	resp['to'] = to - (page >= total_pages ? (to - total) : 0);

	if(datas && is_array(datas))
		datas = datas.slice(offset, offset + per_page)

	resp['datas'] = datas ?? []

	return resp;
}

/**
 * [browse_array_keys description]
 * 
 * @param  {string}			keys
 * @param  {object|array}	datas
 * @param  {object}			options
 * 
 * @return mixed
 */
export const browse_array_keys = (keys, datas, options) => {
	const { separator, default_return } = {
		separator : '.',
		default_return : undefined,
		...(is_object(options) ? options : {})
	}
	let tmp = datas;
	if((is_array(tmp) || is_object(tmp)) && is_string(keys) && is_string(separator)){
		let sep = keys.split(separator);
		for(var key of sep){
			if(tmp?.[key] !== undefined){
				tmp = tmp?.[key];
			}
			else return default_return;
		}
		return tmp;
	}
	return default_return;
}
