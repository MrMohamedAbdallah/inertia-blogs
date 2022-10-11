import React, { useMemo, useRef, useState } from "react";
import { useForm } from "@inertiajs/inertia-react";
import InputError from "@/Components/InputError.jsx";
import PrimaryButton from "@/Components/PrimaryButton.jsx";
import ImageUploader from "quill-image-uploader";
import axios from "axios";
import ReactQuill, { Quill } from "react-quill";
import "react-quill/dist/quill.snow.css";
import { Inertia } from "@inertiajs/inertia";

Quill.register("modules/imageUploader", ImageUploader);

export default function CreateEditBlog({ blog }) {
    const quillRef = useRef(null);

    const modules = useMemo(
        () => ({
            toolbar: {
                container: [
                    [{ header: [1, 2, 3, 4, 5, 6, false] }],
                    ["bold", "italic", "underline", "strike"], // toggled buttons
                    ["blockquote", "code-block"],
                    [{ color: [] }, { background: [] }],
                    [{ header: 1 }, { header: 2 }], // custom button values
                    [{ list: "ordered" }, { list: "bullet" }],
                    [{ direction: "rtl" }], // text direction
                    ["image"],
                    ["clean"], // remove formatting button
                ],
            },

            imageUploader: {
                upload: (file) => {
                    return new Promise((resolve, reject) => {
                        const formData = new FormData();
                        formData.append("image", file);

                        axios
                            .post("/upload-image", formData)
                            .then((res) => {
                                resolve(res.data.url);
                            })
                            .catch((err) => {
                                reject("Upload failed");
                            });
                    });
                },
            },
        }),
        []
    );

    const form = useForm({
        title: blog ? blog.data.title : "",
        body: blog ? blog.data.bodyHTML : "",
        cover: null,
        _method: blog ? "put" : "post",
    });

    const getDefaultValue = () => {
        const html = blog ? blog.data.bodyHTML : "";

        return html;
    };

    const create = (html) => {
        form.transform((data) => ({
            ...data,
            body: html,
        }));
        form.post(route("blogs.store"));
    };

    const update = (html) => {
        form.transform((data) => ({
            ...data,
            body: html,
        }));

        form.post(route("blogs.edit", blog.data.id));
    };

    const submit = (e) => {
        e.preventDefault();
        if (blog) update(quillRef.current.value);
        else create(quillRef.current.value);
    };

    return (
        <div className="my-6">
            <form onSubmit={submit}>
                <div>
                    <label htmlFor="title">Title</label>
                    <input
                        id="title"
                        type="text"
                        value={form.data.title}
                        onChange={(e) => form.setData("title", e.target.value)}
                    />
                    <InputError className="mt-2" message={form.errors.title} />
                </div>

                <div className="mt-4">
                    <label htmlFor="body">Body</label>
                    <div className="bg-white">
                        <ReactQuill
                            theme="snow"
                            modules={modules}
                            defaultValue={getDefaultValue()}
                            ref={quillRef}
                        />
                    </div>
                    <InputError className="mt-2" message={form.errors.body} />
                </div>

                <div className="mt-4">
                    <div className="flex items-center">
                        <label htmlFor="cover" className="mr-2">
                            Cover:{" "}
                        </label>
                        <input
                            type="file"
                            name="cover"
                            id="cover"
                            onChange={(e) =>
                                form.setData("cover", e.target.files[0])
                            }
                        />
                    </div>
                    <InputError className="mt-2" message={form.errors.cover} />
                </div>

                <div className="mt-4 text-right">
                    <PrimaryButton processing={form.processing}>
                        {blog ? "Update" : "Create"}
                    </PrimaryButton>
                </div>
            </form>
        </div>
    );
}
