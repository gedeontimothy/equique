import { is_object } from "../utils/helpers.native";

export const orderProductUpdate = async (datas, url_options = {}, route_) => {

	let response = null;

	try {
		response = await axios.put(route_ ?? route('order-product.update', {...url_options}), is_object(datas) ? datas : {}, {
			headers : {"Content-Type": "application/json"},
		});
		response = Promise.resolve(response.data);
	} catch (error) {
		response = Promise.resolve({data : [], errors : error.response.data.errors, message : error.response.data.message});
	}


	// try {
	// 	response = await fetch(route_ ?? route('order-product.update', {...url_options}), {
	// 		method : 'POST',
	// 		'Content-Type' : 'application/json',
	// 		...(is_object(datas) ? {body : JSON.stringify(datas)} : {})
	// 	});
	// 	if (!response.ok) throw new Error(`Response status: ${response.status}`);

	// 	response = await response.json();

	// } catch (error) {

	// 	response = Promise.resolve({'datas' : [], 'errors' : {message : error.message}});

	// }

	return response;

}
