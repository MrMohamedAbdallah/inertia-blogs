import React, { useEffect, useRef } from "react";
import { usePage, useForm as useInertiaForm } from "@inertiajs/inertia-react";
import PrimaryButton from "@/Components/PrimaryButton.jsx";
import InputError from "@/Components/InputError.jsx";
import { useForm } from "react-hook-form";
import { yupResolver } from "@hookform/resolvers/yup";
import * as yup from "yup";
import classNames from "classnames";

export default function General() {
    const page = usePage();

    const schema = yup.object({
        name: yup.string().required().min(3),
        email: yup.string().email().required(),
        profilePicture: yup
            .mixed()
            .test("fileSize", "The file is too large", (value) => {
                if (!value) return true; // attachment is optional
                console.log(value.size);
                return value.size <= 1024 ** 2 * 2;
            }),
    });

    const {
        register,
        handleSubmit,
        watch,
        setValue,
        formState: { errors: err },
    } = useForm({
        mode: "onBlur",
        defaultValues: {
            name: page.props.auth.user.data.name,
            email: page.props.auth.user.data.email,
            profilePicture: null,
        },
        resolver: yupResolver(schema),
    });

    const profileInput = useRef();

    const { data, setData, post, processing, errors, transform } =
        useInertiaForm({
            name: page.props.auth.user.data.name,
            email: page.props.auth.user.data.email,
            profilePicture: null,
        });

    useEffect(() => {
        setData((data) => {
            return {
                ...data,
                name: watch("name"),
                email: watch("email"),
                profilePicture: watch("profilePicture"),
            };
        });
    }, [watch("name"), watch("email"), watch("profilePicture")]);

    const submit = (values) => {
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

            <form onSubmit={handleSubmit(submit)}>
                <div>
                    <label htmlFor="name">Name</label>
                    <input
                        id="name"
                        type="text"
                        {...register("name")}
                        className={classNames({
                            invalid: errors.name || err.name,
                        })}
                        required
                    />
                    <InputError
                        className="mt-2"
                        message={errors.name || err.name?.message}
                    />
                </div>

                <div className="my-4">
                    <label htmlFor="email">Email</label>
                    <input
                        id="email"
                        type="email"
                        {...register("email")}
                        className={classNames({
                            invalid: errors.email || err.email,
                        })}
                        required
                    />
                    <InputError
                        className="mt-2"
                        message={errors.email || err.email?.message}
                    />
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
                                setValue("profilePicture", e.target.files[0])
                            }
                        />
                    </div>
                    <InputError
                        className="mt-2"
                        message={
                            errors.profilePicture || err.profilePicture?.message
                        }
                    />
                    {err.profilePicture?.message}
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
