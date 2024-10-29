
export const getOrdersByUserIdWithOptions = async (user_id, options = {}, route_) => {

	let response = null;

	try {
		response = await fetch(route_ ?? route('find.orders.by.user.id.with.options', {user_id, ...options}));
		if (!response.ok) throw new Error(`Response status: ${response.status}`);

		response = await response.json();

	} catch (error) {

		response = Promise.resolve({'datas' : [], 'errors' : {message : error.message}});

	}

	return response;

}

export const getOrderProductsByOrderId = async (order_id, options = {}, route_) => {

	let response = null;

	try {
		response = await fetch(route_ ?? route('find.order-products.by.order_id', {order_id, ...options}));
		if (!response.ok) throw new Error(`Response status: ${response.status}`);

		response = await response.json();

	} catch (error) {

		response = Promise.resolve({'datas' : [], 'errors' : {message : error.message}});

	}

	return response;

}
