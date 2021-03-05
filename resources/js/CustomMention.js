import { Mention } from "tiptap-extensions";

export default class CustomMention extends Mention {

	get schema() {
		const customSchema = {
			toDOM: node => [
				"a",
				{
					class: this.options.mentionClass,
					"data-id": node.attrs.id,
					"data-username": node.attrs.label,
					"href": `/user/${node.attrs.label}`
				},
				`@${node.attrs.label.slice(0, -1)}`,
			],
			parseDOM: [
				{
					tag: "a[user-id]",
					getAttrs: dom => {
						const id = dom.getAttribute("user-id");
						const label = dom.innerText.split('@').join('');
						return { id, label }
					},
				},
			],
		};

		return {
			...super.schema,
			...customSchema
		}
	}
}
