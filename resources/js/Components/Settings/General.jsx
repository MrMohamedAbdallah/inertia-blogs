import React, { useRef } from "react";
import { usePage, useForm } from "@inertiajs/inertia-react";
import PrimaryButton from "@/Components/PrimaryButton.jsx";
import InputError from "@/Components/InputError.jsx";

export default function General() {
    const page = usePage();

    const profileInput = useRef();

    const { data, setData, post, processing, errors } = useForm({
        name: page.props.auth.user.data.name,
        email: page.props.auth.user.data.email,
        profilePicture: null,
    });

    const submit = (e) => {
        e.preventDefault();

        post(route("settings.general"), {
            onSuccess() {
                profileInput.current.value = "";
            },
        });
    };

    return (
        <div className="p-4 bg-white rounded-lg shadow">
            <div className="mb-6">
                <div className="w-20 h-20 overflow-hidden bg-gray-300 rounded-full">
                    <img
                        src={page.props.auth.user.data.profilePicture}
                        alt={page.props.auth.user.data.name}
                        className="object-cover object-center w-full h-full"
                    />
                </div>
            </div>

            <form onSubmit={submit}>
                <div>
                    <label htmlFor="name">Name</label>
                    <input
                        id="name"
                        type="text"
                        value={data.name}
                        onChange={(e) => setData("name", e.target.value)}
                        required
                    />
                    <InputError className="mt-2" message={errors.name} />
                </div>

                <div className="my-4">
                    <label htmlFor="email">Email</label>
                    <input
                        id="email"
                        type="email"
                        value={data.email}
                        onChange={(e) => setData("email", e.target.value)}
                        required
                    />
                    <InputError className="mt-2" message={errors.email} />
                </div>

                <div className="my-4">
                    <div className="flex items-center">
                        <label htmlFor="profile_picture" className="mr-2">
                            Profile Picture:{" "}
                        </label>
                        <input
                            type="file"
                            name="profile_picture"
                            id="profile_picture"
                            ref={profileInput}
                            onChange={(e) =>
                                setData("profilePicture", e.target.files[0])
                            }
                        />
                    </div>
                    <InputError
                        className="mt-2"
                        message={errors.profilePicture}
                    />
                </div>

                <div className="text-right">
                    <PrimaryButton processing={processing}>
                        Update
                    </PrimaryButton>
                </div>
            </form>
        </div>
    );
}
