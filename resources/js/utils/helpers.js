import moment from 'moment'

export const stats_format = ({name, stats}) => {
	return [
		{
			title : __('manager.user.base.stats.placed-orders.title'),
			value : stats.total_orders,
			info : __('manager.user.base.stats.placed-orders.description', {name}),
		},
		{
			title : __('manager.user.base.stats.paided-orders.title'),
			value : stats.total_successful_orders,
			info : __('manager.user.base.stats.paided-orders.description'),
		},
		{
			title : __('manager.user.base.stats.in-refundabled-orders.title'),
			value : stats.total_refundable_orders,
			info : __('manager.user.base.stats.in-refundabled-orders.description'),
		},
		{
			title : __('manager.user.base.stats.money-spent.title'),
			value : (stats?.total_money_spent?.total_purchase_price ?? 0) + '$',
			info : __('manager.user.base.stats.money-spent.description', {name}),
		},
	];
}

export const get_tag_type = (k) => {
	const tags = ['info', 'info', 'success', 'warning', 'danger'];
	return tags?.[k];
}

export const get_tag_name = (k) => {
	const tags = [__('main.canceled'), __('main.pending'), __('main.success'), __('main.to-deliver'), __('main.to-repaid'),];
	return tags?.[k];
}

export const get_formatted_date = (date) => {
    const now = moment();
	const diffMinutes = now.diff(date, 'minutes');
	const diffHours = now.diff(date, 'hours');
	const diffDays = now.diff(date, 'days');

	if (diffMinutes < 60) {
		return `Il y a ${diffMinutes} minute${diffMinutes > 1 ? 's' : ''}`;
	} else if (diffHours < 24) {
		return `Il y a ${diffHours} heure${diffHours > 1 ? 's' : ''}`;
	} else if (diffDays === 1) {
		return `Hier à ${moment(date).format('HH:mm')}`;
	} else if (diffDays === 2) {
		return `Avant-hier à ${moment(date).format('HH:mm')}`;
	} else if (diffDays <= 3) {
		return `Il y a ${diffDays} jour${diffDays > 1 ? 's' : ''} à ${moment(date).format('HH:mm')}`;
	} else {
		return `${moment(date).format('dddd DD MMMM YYYY')} à ${moment(date).format('HH:mm')}`;
	}
}


export const get_service = async (route) => {

	let response = null;

	try {
		response = await fetch(route);
		if (!response.ok) throw new Error(`Response status: ${response.status}`);

		response = await response.json();

	} catch (error) {

		response = Promise.resolve({'datas' : [], 'errors' : {message : error.message}});

	}

	return response;

}