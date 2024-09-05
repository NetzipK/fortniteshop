const Discord = require("discord.js");
var XMLHttpRequest = require("xmlhttprequest").XMLHttpRequest;
const client = new Discord.Client();

client.on("ready", () => {
	console.log("Connected as " + client.user.tag);
});

client.on("message", (message) => {
	// If the message is "ping"
	if (message.content === "ping") {
		// Send "pong" to the same channel
		message.channel.send("pong");
	}

	const prefix = "-";
	if (!message.content.startsWith(prefix) || message.author.bot) return;

	var args = message.content.slice(prefix.length).split(" ");
	const command = args.shift().toLowerCase();
	if (command === "done") {
		if (!args.length) {
			return message
				.delete()
				.then((msg) =>
					message.channel
						.send(`You didn\'t provide any order, ${msg.author}!`)
						.then((msg) => msg.delete(60000))
						.catch(console.error)
				)
				.catch(console.error);
		}
		args = args.pop();

		if (args.charAt(0) === "#") {
			args = args.slice(1);
		}
		message.channel
			.send(`Order #${args} is being delivered...`)
			.then((msg) => msg.delete(60000))
			.catch(console.error);
		var xhr = new XMLHttpRequest();
		xhr.open("POST", "https://fortnitemall.gg/discord/deliver", true);
		xhr.setRequestHeader("Content-Type", "application/json");
		xhr.send(
			JSON.stringify({
				invoiceId: args,
				by: message.author.username,
			})
		);
		xhr.onreadystatechange = function() {
			if (xhr.readyState == 4) {
				if (xhr.status == 200) {
					console.log(xhr.responseText.startsWith("200"));
					if (xhr.responseText.startsWith("200")) {
						message
							.delete()
							.then((msg) =>
								message.channel
									.send(
										`Order #${args} delivered by ${
											msg.author.username
										}`
									)
									.then((msg) => msg.delete(600000))
									.catch(console.error)
							)
							.catch(console.error);
						message.channel
							.fetchMessages()
							.then((messages) => {
								const toDelete = messages.filter((msg) =>
									msg.content.includes(args + " ;")
								);
								// console.log(toDelete);
								message.channel.bulkDelete(toDelete);
							})
							.catch(console.error);
					} else {
						message
							.delete()
							.then((msg) =>
								message.channel
									.send(
										`Failed order delivery, check invoice ID Mr. ${
											msg.author.username
										}!`
									)
									.then((msg) => msg.delete(300000))
									.catch(console.error)
							)
							.catch(console.error);
					}
				}
			}
		};
	}

	if (command === "refund") {
		if (!args.length) {
			return message
				.delete()
				.then((msg) =>
					message.channel
						.send(`You didn\'t provide any order, ${msg.author}!`)
						.then((msg) => msg.delete(60000))
						.catch(console.error)
				)
				.catch(console.error);
		}
		args = args.pop();

		if (args.charAt(0) === "#") {
			args = args.slice(1);
		}
		message.channel
			.send(`Order #${args} is being refunded...`)
			.then((msg) => msg.delete(60000))
			.catch(console.error);
		var xhr = new XMLHttpRequest();
		xhr.open("POST", "https://fortnitemall.gg/discord/refund", true);
		xhr.setRequestHeader("Content-Type", "application/json");
		xhr.send(
			JSON.stringify({
				invoiceId: args,
			})
		);
		xhr.onreadystatechange = function() {
			if (xhr.readyState == 4) {
				if (xhr.status == 200) {
					// console.log(xhr.responseText.startsWith("200"));
					if (xhr.responseText.startsWith("200")) {
						message
							.delete()
							.then((msg) =>
								message.channel.send(
									`Order #${args} refunded by ${
										msg.author.username
									}`
								)
							)
							.catch(console.error);
						message.channel
							.fetchMessages()
							.then((messages) => {
								const toDelete = messages.filter((msg) =>
									msg.content.includes(args + " ;")
								);
								// console.log(toDelete);
								message.channel.bulkDelete(toDelete);
							})
							.catch(console.error);
					} else {
						message
							.delete()
							.then((msg) =>
								message.channel
									.send(
										`Failed order refund, check invoice ID Mr. ${
											msg.author.username
										}!`
									)
									.then((msg) => msg.delete(300000))
									.catch(console.error)
							)
							.catch(console.error);
					}
				}
			}
		};
	}

	if (command === "mine") {
		if (!args.length) {
			return message
				.delete()
				.then((msg) =>
					message.channel
						.send(`You didn\'t provide any order, ${msg.author}!`)
						.then((msg) => msg.delete(60000))
						.catch(console.error)
				)
				.catch(console.error);
		}
		args = args.pop();

		if (args.charAt(0) === "#") {
			args = args.slice(1);
		}
		message
			.delete()
			.then(
				message.channel
					.fetchMessages()
					.then((messages) => {
						const hasHisOrder = messages.filter((msg) =>
							msg.content.includes(
								"Taken care of by " + message.author
							)
						);
						messagesMentionFound = hasHisOrder.array().length;
						if (
							messagesMentionFound > 0 &&
							!message.member.hasPermission("ADMINISTRATOR")
						) {
							message.channel
								.send(
									`You already have an order assigned, ${
										message.author
									}!`
								)
								.then((msg) => msg.delete(20000))
								.catch(console.error);
						} else {
							const toDelete = messages.filter(
								(msg) =>
									msg.content.includes(args + " ;") &&
									msg.author.bot
							);
							messagesFound = toDelete.array().length;
							if (messagesFound > 0) {
								theMessage = toDelete.first();
								if (
									theMessage.content.includes("Taken care of")
								) {
									message.channel
										.send(
											`Order is already being taken care of by someone else, ${
												message.author
											}!`
										)
										.then((msg) => msg.delete(30000))
										.catch(console.error);
								} else {
									theMessage.edit(
										theMessage.content +
											`\n\nTaken care of by ${
												message.author
											}!`
									);
								}
							} else {
								message.channel
									.send(
										`No running order with give invoice found, ${
											message.author
										}!`
									)
									.then((msg) => msg.delete(30000))
									.catch(console.error);
							}
						}
					})
					.catch(console.error)
			)
			.catch(console.error);
	}

	if (command === "unassign") {
		if (!args.length) {
			return message
				.delete()
				.then((msg) =>
					message.channel
						.send(`You didn\'t provide any order, ${msg.author}!`)
						.then((msg) => msg.delete(60000))
						.catch(console.error)
				)
				.catch(console.error);
		}
		args = args.pop();

		if (args.charAt(0) === "#") {
			args = args.slice(1);
		}
		message
			.delete()
			.then(
				message.channel
					.fetchMessages()
					.then((messages) => {
						const toDelete = messages.filter(
							(msg) =>
								msg.content.includes(args + " ;") &&
								msg.author.bot
						);
						messagesFound = toDelete.array().length;
						if (messagesFound > 0) {
							theMessage = toDelete.first();
							if (theMessage.content.includes("Taken care of")) {
								message.channel
									.send(
										`${
											message.author
										} is no longer taking care of order #${args}!`
									)
									.then((msg) => msg.delete(300000))
									.catch(console.error);
								originalMessage = theMessage.content
									.split("\n\n")
									.shift();
								theMessage.edit(originalMessage);
							} else {
								message.channel
									.send(
										`Order is not being taken care of by anyone, ${
											message.author
										}!`
									)
									.then((msg) => msg.delete(30000))
									.catch(console.error);
							}
						} else {
							message.channel
								.send(
									`No running order with give invoice found, ${
										message.author
									}!`
								)
								.then((msg) => msg.delete(30000))
								.catch(console.error);
						}
					})
					.catch(console.error)
			)
			.catch(console.error);
	}
	if (command === "restore") {
		if (message.member.hasPermission("ADMINISTRATOR")) {
			if (!args.length) {
				return message
					.delete()
					.then((msg) =>
						message.channel
							.send(
								`You didn\'t provide any order, ${msg.author}!`
							)
							.then((msg) => msg.delete(60000))
							.catch(console.error)
					)
					.catch(console.error);
			}
			args = args.pop();

			if (args.charAt(0) === "#") {
				args = args.slice(1);
			}
			message.channel
				.send(`Order #${args} is being restored...`)
				.then((msg) => msg.delete(60000))
				.catch(console.error);
			var xhr = new XMLHttpRequest();
			xhr.open("POST", "https://fortnitemall.gg/discord/restore", true);
			xhr.setRequestHeader("Content-Type", "application/json");
			xhr.send(
				JSON.stringify({
					invoiceId: args,
				})
			);
			xhr.onreadystatechange = function() {
				if (xhr.readyState == 4) {
					if (xhr.status == 200) {
						// console.log(xhr.responseText.startsWith("200"));
						if (xhr.responseText.startsWith("200")) {
							message.delete();
						} else {
							message
								.delete()
								.then((msg) =>
									message.channel
										.send(
											`Failed order restore, check invoice ID Mr. ${
												msg.author.username
											}!`
										)
										.then((msg) => msg.delete(60000))
										.catch(console.error)
								)
								.catch(console.error);
						}
					}
				}
			};
		} else {
			message
				.delete()
				.then((msg) =>
					message.channel
						.send(
							`You have no permission to use that command, please ask an administrator for help ${
								msg.author
							}.`
						)
						.then((msg) => msg.delete(20000))
						.catch(console.error)
				)
				.catch(console.error);
		}
	}

	if (message.channel.id == 594854110424072218) {
		if (command === "accept") {
			if (!args.length) {
				return message
					.delete()
					.then((msg) =>
						message.channel
							.send(
								`You didn\'t provide any User, ${msg.author}!`
							)
							.then((msg) => msg.delete(60000))
							.catch(console.error)
					)
					.catch(console.error);
			}
			args = args.pop();

			message.channel
				.send(`Cashout request of ${args} is being accepted...`)
				.then((msg) => msg.delete(60000))
				.catch(console.error);

			var xhr = new XMLHttpRequest();
			xhr.open(
				"POST",
				"https://fortnitemall.gg/discord/acceptCashout",
				true
			);
			xhr.setRequestHeader("Content-Type", "application/json");
			xhr.send(
				JSON.stringify({
					user: args,
				})
			);
			xhr.onreadystatechange = function() {
				if (xhr.readyState == 4) {
					if (xhr.status == 200) {
						console.log(xhr.responseText.startsWith("200"));
						if (xhr.responseText.startsWith("200")) {
							message
								.delete()
								.then((msg) =>
									message.channel
										.send(
											`Cashout request of ${args} accepted by ${
												msg.author.username
											}`
										)
										.then((msg) => msg.delete(600000))
										.catch(console.error)
								)
								.catch(console.error);
							message.channel
								.fetchMessages()
								.then((messages) => {
									const toDelete = messages.filter(
										(msg) =>
											msg.content.includes(args) &&
											msg.author.bot
									);
									// console.log(toDelete);
									message.channel.bulkDelete(toDelete);
								})
								.catch(console.error);
						} else {
							message
								.delete()
								.then((msg) =>
									message.channel
										.send(
											`Failed finding cashout request, check invoice ID Mr. ${
												msg.author.username
											}!`
										)
										.then((msg) => msg.delete(300000))
										.catch(console.error)
								)
								.catch(console.error);
						}
					}
				}
			};
		}

		if (command === "deny") {
			if (!args.length) {
				return message
					.delete()
					.then((msg) =>
						message.channel
							.send(
								`You didn\'t provide any User, ${msg.author}!`
							)
							.then((msg) => msg.delete(60000))
							.catch(console.error)
					)
					.catch(console.error);
			}
			args = args.pop();

			message.channel
				.send(`Cashout request of ${args} is being denied...`)
				.then((msg) => msg.delete(60000))
				.catch(console.error);

			var xhr = new XMLHttpRequest();
			xhr.open(
				"POST",
				"https://fortnitemall.gg/discord/denyCashout",
				true
			);
			xhr.setRequestHeader("Content-Type", "application/json");
			xhr.send(
				JSON.stringify({
					user: args,
				})
			);
			xhr.onreadystatechange = function() {
				if (xhr.readyState == 4) {
					if (xhr.status == 200) {
						console.log(xhr.responseText.startsWith("200"));
						if (xhr.responseText.startsWith("200")) {
							message
								.delete()
								.then((msg) =>
									message.channel
										.send(
											`Cashout request of ${args} denied by ${
												msg.author.username
											}`
										)
										.then((msg) => msg.delete(600000))
										.catch(console.error)
								)
								.catch(console.error);
							message.channel
								.fetchMessages()
								.then((messages) => {
									const toDelete = messages.filter(
										(msg) =>
											msg.content.includes(args) &&
											msg.author.bot
									);
									// console.log(toDelete);
									message.channel.bulkDelete(toDelete);
								})
								.catch(console.error);
						} else {
							message
								.delete()
								.then((msg) =>
									message.channel
										.send(
											`Failed finding cashout request, check invoice ID Mr. ${
												msg.author.username
											}!`
										)
										.then((msg) => msg.delete(300000))
										.catch(console.error)
								)
								.catch(console.error);
						}
					}
				}
			};
		}
	}
});

bot_secret_token = "DISCORD_BOT_TOKEN";

client.login(bot_secret_token);
