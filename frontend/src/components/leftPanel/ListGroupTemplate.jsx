import Profile from "./Profile";

const ListGroupTemplate = () => {
  return (
    <li className="cursor-pointer hover:bg-clear hover:text-dark">
      <div className="w-full border-1 border-grey h-16 flex items-center justify-between px-4">
        <div className="flex items-center">
          <Profile />
          <p>Username</p>
        </div>
        <date>Hier</date>
      </div>
    </li>
  );
};

export default ListGroupTemplate;
