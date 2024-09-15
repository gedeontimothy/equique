/**
 * [Description for getLangAvailable]
 *
 * @param String route
 * 
 * @return Object
 * 
 */
export const getLangAvailable = async (route_) => {

    let response = null;

    try {
		response = await fetch(route_ ?? route('lang.available'));
		if (!response.ok) throw new Error(`Response status: ${response.status}`);

		response = await response.json();

	} catch (error) {

		response = {'datas' : [], 'errors' : {message : error.message}}

    }

    return response;

}

/**
 * [Description for getCurrentLangDatas]
 *
 * @param String route
 * 
 * @return Object
 * 
 */
export const getCurrentLangDatas = async (route_) => {

    let response = null;

    try {
		response = await fetch(route_ ?? route('lang.show'));
		if (!response.ok) throw new Error(`Response status: ${response.status}`);

		response = await response.json();

	} catch (error) {

		response = {'datas' : [], lang : null, 'errors' : {message : error.message}}

    }

    return response;

}

/**
 * [Description for getLangDatas]
 *
 * @param String lang
 * @param String route
 * 
 * @return Object
 * 
 */
export const getLangDatas = async (lang, route_) => {

    let response = null;

    try {
		response = await fetch(route_ ?? route('lang.show', {lang}));
		if (!response.ok) throw new Error(`Response status: ${response.status}`);

		response = await response.json();

	} catch (error) {

		response = {'datas' : [], lang, 'errors' : {message : error.message}}

    }

    return response;

}
