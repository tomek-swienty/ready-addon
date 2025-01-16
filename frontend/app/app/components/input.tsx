interface IProps {
    disabled: boolean;
    className: string;
}

export default function Input({ disabled = false, className = '', ...props }: IProps) {
    return (
        <input
            disabled={disabled}
            className={`${className} outline-none border rounded border-gray-200 h-10 px-2`}
            {...props}
        />
    )
}
