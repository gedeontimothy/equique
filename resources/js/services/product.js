
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